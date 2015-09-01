var React = require('react');

var queryString = require('query-string')


var AnswerButton = React.createClass({

  getInitialState: function() {
    return {
      pulseClass: 'no-pulse',
      plusOneClass: 'no-fadeOutUp'
    }
  },

  componentWillMount: function() {
    var parsedString = queryString.parse(location.search)     
    if ((parsedString.answer-1) == this.props.index) {
      this.props.supplyClick(this.props.index)
    }
  },

  componentWillReceiveProps: function(newData) {
    // If the no. of votes has changed
    if (newData.votes != this.props.votes) {
      this.setState({
        pulseClass: 'pulse'
      })

      this.setState({
        plusOneClass: 'fadeOutUp'
      })

      setTimeout(this._resetPulse, 800)
      setTimeout(this._resetPlusOne, 800)
    }
  },

  _resetPlusOne: function() {
    this.setState({
      plusOneClass: 'no-fadeOutUp'
    })
  },

  _resetPulse: function() {
    this.setState({
      pulseClass: 'no-pulse'
    })
  },

  _handleClick: function(event) {
    event.preventDefault();
    if (event.target.name !== undefined) {
      this.props.supplyClick(event.target.name);
    }
  },

  _buttonStyle: {
    width: '100%',
    margin: '20px auto',
    display: 'block'
  },

  render: function() {
    var classes = "btn senti-poll-vote-button btn-block btn-lg btn-default " + this.state.pulseClass
    return (
      <div className="senti-poll-button-wrapper">
        <button
          style={this._buttonStyle}
          name={this.props.index}
          className={classes}
          onClick={this._handleClick}
        >
          {this.props.text}
        </button>
        <div name={this.props.index} className={this.state.plusOneClass}>+1</div>
      </div>
    )
  }
});

module.exports = AnswerButton;
