/**
 * @jsx React.DOM
 */

var React = require('react');

var Accordion = React.createClass({
    renderChildren: function(children, index) {
        var title = this.props.titles[index];

        return (
            <div>
                <h2>{title}</h2>
                {children}
            </div>
        );
    },

    render: function() {
        return (
            <div>
                {React.Children.map(this.props.children, this.renderChildren)}
            </div>
        );
    }
});

module.exports = Accordion;
