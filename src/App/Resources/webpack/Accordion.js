/**
 * @jsx React.DOM
 */

var React = require('react');

var Accordion = React.createClass({
    getInitialState: function() {
        return {
            value: 'initia'
        };
    },

    renderChildren: function(children, index) {
        var title = this.props.titles[index];

        return (
            <div>
                <h2>{title}</h2>
                {children}
            </div>
        );
    },

    handleChange: function(event) {
        this.setState({value: event.target.value});
    },

    render: function() {
        return (
            <div>
                <input onChange={this.handleChange} value={this.state.value} />
                {React.Children.map(this.props.children, this.renderChildren)}
            </div>
        );
    }
});

module.exports = Accordion;
