import React from 'react';
import ReactDOM from 'react-dom';
import NoteContainer from './NoteContainer';
import registerServiceWorker from './registerServiceWorker';

ReactDOM.render(
    <div>
        <NoteContainer />
    </div>
    , document.getElementById('root')
);

registerServiceWorker();
