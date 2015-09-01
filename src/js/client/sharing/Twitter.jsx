var React = require('react')

var TwitterButton = React.createClass({

  _getTwitterHandle: function() {
    if (window.location.host == "www.stylist.co.uk") {
      return "@StylistMagazine"
    } else if (window.location.host == "www.emeraldstreet.com") {
      return "@EmeraldStreet"
    } else if (window.location.host == "www.mrhyde.com") {
      return "@Mr_Hyde"
    } else {
      return "@ShortList" 
    }
  },

  _text: function() {
    return encodeURIComponent(this.props.question + ' I voted for ' + this.props.answer + ' ' + this._getTwitterHandle())
  },

  _doShare: function() {
    this.props.share()
    var url = `https://twitter.com/intent/tweet?text=${this._text()}&url=${window.location.href}`
    window.open(url,'','height=300,width=600');
  },

  render: function() {
    return (
      <button 
        className="senti-poll-sharing-button senti-poll-sharing-twitter btn"
        onClick={this._doShare}
      >
        Twitter
      </button>
    )
  }
})

module.exports = TwitterButton


