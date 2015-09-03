var React = require('react');

var FacebookButton = require('./sharing/Facebook.jsx')
var TwitterButton = require('./sharing/Twitter.jsx')
var GoogleButton = require('./sharing/Google.jsx')

var Sharing = React.createClass({

  getInitialState: function() {
    return {
      shareText: '',
      wrapperClass: 'hide-wrapper'
    }
  },

  componentWillMount: function() {
    this.setState(this.props.answers[this.props.votedFor]);
    setTimeout(this._revealWrapper, 2500)
  },
  componentWillReceiveProps: function(newProps) {
    this.setState(newProps.answers[newProps.votedFor]);
  },

  _registerShare: function() {
    var shareRef = new Firebase("https://senti.firebaseio.com/polls/" + this.props.firebaseId + "/answers/" + this.props.votedFor + "/shareClicks");
    shareRef.transaction(function (current_value) {
      return (parseInt(current_value) || 0) + 1;
    });
  },

  _revealWrapper: function() {
    this.setState({wrapperClass: 'show-wrapper'})
  },

  render: function() {
    return (
      <div className={`senti-poll-sharing-wrapper ${this.state.wrapperClass}`}>
        <div className="senti-poll-bfc"></div>
        <div className="senti-poll-sharing-content">
          <div className="senti-poll-quote">
            “<em>{this.props.question} I voted for <span className="senti-poll-black-bold">{this.state.text}</span></em>”
          </div>
          <div className="senti-poll-share-row">
            <FacebookButton share={this._registerShare} question={this.props.question} {...this.state} />
            <TwitterButton share={this._registerShare} question={this.props.question} answer={this.state.text}/>
            <GoogleButton share={this._registerShare} />
          </div>
        </div>
      </div>
    )
  }
});

module.exports = Sharing;
