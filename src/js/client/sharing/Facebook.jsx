var React = require('react')

var FacebookButton = React.createClass({
  componentWillMount: function() {
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    window.fbAsyncInit = function() {
      FB.init({
        appId      : FB_APP_ID,
        cookie     : true,  // enable cookies to allow the server to access
                          // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.1' // use version 2.1
      });
    };
  },

  _buildCaption: function() {
    return this.props.question + ' I voted for ' + this.props.text
  },

  _doShare: function() {
      this.props.share()
      FB.ui({
        method: 'feed',
        link: window.location.href + '?senti=true',
        name: this._buildCaption(),
        description: 'See the latest results in realtime and have your say on ' + window.location.hostname,
        show_error: true,
        redirect_uri: window.location.href
    }, function(response){});
  },

  render: function() {
    return (
      <button
        className="senti-poll-sharing-button senti-poll-sharing-facebook btn"
        onClick={this._doShare}
      >
        Facebook
      </button>
    )
  }
});

module.exports = FacebookButton;
