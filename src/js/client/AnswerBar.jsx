var React = require('react');
var prefixr = require('react-prefixr');

var AnswerBar = React.createClass({

  getInitialState: function() {
    return {
      firstLoad: true
    }
  },

  _calculatePercentage: function() {
    if (this.state.firstLoad) {
      setTimeout(this._updateLoadState, 500)
      return 0;
    }
    return (this.props.votes/this.props.entries)*100;
  },

  _updateLoadState: function() {
    this.setState({
      firstLoad: false
    })
  },

  _progressStyle: {
    padding: '5px 0px'
  },

  _labelStyle: {
    fontSize: '18px',
    fontWeight: '100',
    color: 'black'
  },

  _brandBackground: function() {
    var color = "";
    switch (window.location.hostname) {
      case "www.shortlist.com":
        color ="#00b9f2";
        break;
      case "www.stylist.co.uk":
        color = "#2abeaa";
        break;
      case "www.emeraldstreet.com":
        color = "#333333";
        break;
    }
    return color;
  },

  render: function() {
    var p = this._calculatePercentage().toFixed(2);
    var barStyle = {
      width: p + '%',
      fontSize: "24px",
      lineHeight: "27px",
      backgroundColor: "#eaeaea",
      transition: "all 1s ease-out"
    };
    var brandStyle = {
      width: p + '%',
      backgroundColor: this._brandBackground(),
      transition: "all 1s ease-out",
      height: '10px'
    };
    var textStyle = {
      color: this._brandBackground()
    }
    return (
      <div style={{marginBottom:'20px'}}>
        <div className="senti-poll-progress" style={this._progressStyle}>
          <div className="senti-poll-progress-bar" role="progressbar" aria-valuenow="{p}" aria-valuemin="0" aria-valuemax="100" style={prefixr(barStyle)}>
            <div className="senti-poll-progress-text" style={textStyle}>{p}%</div>
          </div>
          <div className="senti-poll-brand-bar" style={prefixr(brandStyle)}>
          </div>
        </div>
        <span style={this._labelStyle}>{this.props.text}</span>
        <br/>
      </div>
    );
  }
});

module.exports = AnswerBar;
