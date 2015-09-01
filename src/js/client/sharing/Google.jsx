var React = require('react')

var GoogleButton = React.createClass({

  _doShare: function() {
    this.props.share()
    var url = 'https://plus.google.com/share?url=' + window.location.href
    window.open(url,'','height=500,width=800');
  },

  render: function() {
    return (
      <button 
        className="senti-poll-sharing-button senti-poll-sharing-google btn"
        onClick={this._doShare}
      >
        Google+
      </button>
    )
  }
})

module.exports = GoogleButton


