var React = require('react');

var AnswerBar = require('./AnswerBar.jsx');

var Results = React.createClass({

  _renderGraph: function() {
    var graphComponents = [];
    var answers = this.props.pollData.answers;
    answers.map(function(answer, index) {
      graphComponents.push(<AnswerBar key={index} {...answer} entries={this.props.pollData.entries}/>);
    }, this);
    return graphComponents;
  },

  render: function() {
    return (
      <div>
        {this._renderGraph()}
      </div>
    );
  }
});

module.exports = Results;
