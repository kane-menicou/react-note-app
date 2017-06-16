import React, {Component} from 'react';
import './css/main.css'
import './css/font-awesome-4.7.0/css/font-awesome.min.css'

class Note extends Component {
    render() {
        if (this.props.isEditing === true) {
            return (
                <div style={this.props.style} className="note">
                <span className="note-content">
                    <i className={this.props.icon}> </i>
                    <div className="noteText">
                        <input type="text"
                               value={this.props.text}
                               onChange={this.props.onTextChange.bind(this.props.index, this.props.index)}
                               onKeyPress={function (evt) {
                                   if (evt.key === 'Enter') {
                                       let func = this.props.onSaveClick.bind(this.props.index, this.props.index);
                                       func();
                                   }
                               }.bind(this)}
                        />
                    </div>
                </span>
                    <div className="rightIcon">
                        <i className={this.props.saveIcon}
                           onClick={this.props.onSaveClick.bind(this.props.index, this.props.index)}> </i>
                    </div>
                </div>
            );
        }
        return (
            <div style={this.props.style} className="note">
                <div className="noteText">
                    <span className="note-content" onClick={this.props.onClick.bind(this.props.index, this.props.index)}>
                        <i className={this.props.icon}> </i> {this.props.text}
                    </span>
                </div>
                <div className="rightIcon">
                    <i className={this.props.editIcon}
                       onClick={this.props.onEditClick.bind(this.props.index, this.props.index)}> </i>
                    <i className={this.props.removeIcon}
                       onClick={this.props.onDeleteClick.bind(this.props.index, this.props.index)}> </i>
                </div>
            </div>
        );
    }
}

export default Note;