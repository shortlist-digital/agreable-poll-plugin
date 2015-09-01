/** React.DOM */
window.__bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

window.React = require('react/addons');
var store = require('store')
var ReactCSSTransitionGroup = React.addons.CSSTransitionGroup;
var ReactFire = require('reactfire');

var Answers = require('./Answers.jsx');
var Results = require('./Results.jsx');
var Sharing = require('./Sharing.jsx');

var addCommas = require('add-commas');

var App = React.createClass({
  mixins: [ReactFire],

  _checkStoreForVote: function() {
    if (store.get(this.props.firebaseId)) {
      return true
    } else {
      return false
    }
  },

  _checkVoteValue: function() {
    if (store.get(this.props.firebaseId)) {
      return store.get(this.props.firebaseId)
    } else {
      return 0
    }
  },

  getInitialState: function() {
    return {
      userVoted: this._checkStoreForVote(),
      votedFor: this._checkVoteValue(),
      pollData: {
        entries: 0,
        question: "",
        answers: []
      }
    }
  },

  _handleVote: function(answerId) {
    var voteRef = new Firebase("https://senti.firebaseio.com/polls/" + this.props.firebaseId + "/answers/" + answerId + "/votes");
    voteRef.transaction(function (current_value) {
      return (parseInt(current_value) || 0) + 1;
    });
    var entriesRef = new Firebase("https://senti.firebaseio.com/polls/" + this.props.firebaseId + "/entries");
    entriesRef.transaction(function (current_value) {
      return (parseInt(current_value) || 0) + 1;
    });
    this.setState({
      userVoted: true,
      votedFor: answerId
    });
    store.set(this.props.firebaseId, answerId)
  },

  componentWillMount: function() {
    if (window.location.hash == '#clear-senti') {
      store.set(this.props.firebaseId, false)
      this.setState({userVoted: false})
    }

    this.bindAsObject(new Firebase("https://senti.firebaseio.com/polls/" + this.props.firebaseId), "pollData");
  },

  _readableNumbers: function() {
    return addCommas(this.state.pollData.entries);
  },

  _votesSoFar: function() {
    if (this.state.pollData.entries > 10) {
      return (
        <label className="senti-poll-votes-so-far">{this._readableNumbers()} votes</label>
      )
    } else {
      return (<span></span>)
    }
  },

  _renderSubComponents: function() {
    if (!this.state.userVoted) {
      return (
        <Answers key="answers" answers={this.state.pollData.answers} handleVote={this._handleVote}/>
      )
    } else {
      return (
        <div>
          <Results key="results" {...this.state}/>
          <Sharing firebaseId={this.props.firebaseId} key="sharing" question={this.state.pollData.question} answers={this.state.pollData.answers} votedFor={this.state.votedFor}/>
        </div>
      )
    }
  },

  render: function() {
    return (
      <div>
        <h1 className="senti-poll-question">{this.state.pollData.question}</h1>
        {this._votesSoFar()}
        {this._renderSubComponents()}
      </div>
    )
  }

});

var sentiBlock = document.getElementsByClassName('senti-poll')[0];
var firebaseId = sentiBlock.getAttribute('data-firebase-id');

React.render(<App firebaseId={firebaseId}/>, sentiBlock);

