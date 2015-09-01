var React = require('react');

var AnswerButton = require('./AnswerButton.jsx');

var Answers = React.createClass({
  getInitialState: function() {
    return {
      answers: []
    }
  },

  componentWillReceiveProps: function(newProps) {
    this.setState({
      answers: newProps.answers
    });
  },

  _renderAnswers: function() {
    if (this.props.answers) {
      var answerComponents = [];
      var answers = this.props.answers;
      answers.map(function(answer, index) {
        answerComponents.push(
          <AnswerButton
            key={index}
            index={index}
            {...answer}
            supplyClick={this.props.handleVote}
          />
        ); 
      }, this);
      return answerComponents;
    } else {
      return (<span></span>);
    }
  },

  render: function() {
    return (
      <div className="senti-poll-answers">
        {this._renderAnswers()}
      </div>
    )
  }
});

module.exports = Answers;
