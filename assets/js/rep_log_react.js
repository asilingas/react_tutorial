import React from 'react';
import ReactDom from 'react-dom';

const el = React.createElement(
    'h2',
    null,
    'Kėlimo istorija',
    React.createElement('span', null, '!')
);

ReactDom.render(el, document.getElementById('lift-stuff-app'));