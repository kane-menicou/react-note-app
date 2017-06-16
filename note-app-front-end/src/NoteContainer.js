import React, {Component} from 'react';
import Note from './Note'

class NoteContainer extends Component {
    constructor() {
        super();
        this.state = {
            stateToSave: {
                notes: [],
                states: [],
                testData: 'Not correct',
            },
            websocket: NoteContainer.startWebsocket('ws://127.0.0.1:8081'),
            refreshIcon: 'fa fa-refresh',
            stateLoaded: false,
            list: window.location.pathname,
            error: false
        };
    }

    static startWebsocket(url) {
        return new WebSocket(url);
    }

    getState() {
        this.state.websocket.send(JSON.stringify({
            action: 'GetNoteData',
            list: this.state.list
        }));

        this.state.websocket.onmessage = function (evt) {
            console.log();
            if (Object.keys(JSON.parse(evt.data))[0] === 'error') {
                this.setState(JSON.parse(evt.data));
                return;
            }

            this.setState(
                JSON.parse(evt.data)
            );
        }.bind(this);
        this.setState({
            stateLoaded: true
        });
    }

    saveState() {
        this.state.websocket.send(
            JSON.stringify({
                action: 'UpdateState',
                state: this.state.stateToSave
            }));
    }

    onNoteClick(index, event) {
        let note = this.state.stateToSave.notes[index];

        if (typeof(this.state.stateToSave.states[this.state.stateToSave.notes[index].stateIndex + 1]) !== 'undefined') {
            note.stateIndex = note.stateIndex + 1;
        } else {
            note.stateIndex = 0;
        }

        this.saveState();
        this.setState(note);
    }

    addNewNote(event) {
        let notes = this.state.stateToSave.notes;

        notes.push({
            'state': 0,
            'noteText': 'Add note text here',
            'stateIndex': 0
        });

        this.setState(notes);
        this.saveState()
    }

    deleteNote(index, event) {
        let notes = this.state.stateToSave.notes;

        if (window.confirm('Are you sure you want to remove this note?')) {
            notes.splice(index, 1);

            this.setState(notes);
            this.saveState()
        }
    }

    editNote(index, event) {
        let notes = this.state.stateToSave.notes;
        notes[index].editing = true;

        this.setState(notes);
        this.saveState();
    }

    saveNote(index, event) {
        let notes = this.state.stateToSave.notes;
        notes[index].editing = false;

        this.setState(notes);
        this.saveState();
    }

    onChange(index, event) {
        let notes = this.state.stateToSave.notes;
        notes[index].noteText = event.target.value;

        this.setState(notes);
        this.saveState();
    }

    render() {
        let notes = [];
        for (let i = 0; i < this.state.stateToSave.notes.length; i++) {
            notes.push(
                <Note
                    style={this.state.stateToSave.states[this.state.stateToSave.notes[i].stateIndex].style}
                    onClick={this.onNoteClick.bind(this)}
                    key={i}
                    index={i}
                    text={this.state.stateToSave.notes[i].noteText}
                    icon={this.state.stateToSave.states[this.state.stateToSave.notes[i].stateIndex].icon}
                    removeIcon="fa fa-trash"
                    editIcon="fa fa-pencil"
                    saveIcon="fa fa-floppy-o"
                    onDeleteClick={this.deleteNote.bind(this)}
                    onEditClick={this.editNote.bind(this)}
                    onSaveClick={this.saveNote.bind(this)}
                    onTextChange={this.onChange.bind(this)}
                    isEditing={this.state.stateToSave.notes[i].editing}
                />
            );
        }

        if (this.state.error !== false) {
            return (
                <div>
                    <i className="errorIcon fa fa-warning fa-5x"> </i>
                    <h1 className="errorTitle">{this.state.error}</h1>
                </div>
            );
        } else if (this.state.stateLoaded === false) {
            return (
                <div className="noteContainer">
                    <button className="notesRefreshButton topButton" onClick={this.getState.bind(this)}>
                        <i className={this.state.refreshIcon}> </i> Refresh Notes
                    </button>
                    {notes}
                </div>
            );
        }

        return (
            <div className="noteContainer">
                <button className="newNoteButton topButton" onClick={this.addNewNote.bind(this)}>
                    <i className="fa fa-plus"> </i> New Note
                </button>
                {notes}
            </div>
        );
    }
}

export default NoteContainer;
