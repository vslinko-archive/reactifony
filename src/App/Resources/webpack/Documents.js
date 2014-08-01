/**
 * @jsx React.DOM
 */

var React = require('react');

var Accordion = React.createClass({
    renderDocument: function(document) {
        return (
            <li>
                {document.title}
            </li>
        );
    },

    render: function() {
        return (
            <ul>
                {this.props.documents.map(this.renderDocument)}
            </ul>
        );
    }
});

module.exports = Accordion;
