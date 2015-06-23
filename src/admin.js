$ = jQuery;

class AdminPoll {

  constructor (options) {

    console.log('AdminPoll::constructor')

    this.firebase = new Firebase("https://senti.firebaseio.com/")
    // console.log(this.firebase);

    this.$el = $(options.el)

    var data = {
      'action': 'get_firebase_path',
      'post_id': parseInt(this.$el.attr('id').replace('post-', ''))
    };

    $.post(ajaxurl, data, $.proxy(this.getRecord, this));

  }

  getRecord(path){
    this.firebase.child(path).on("value", $.proxy(this.render, this));
  }

  render(snapshot){
    var data = snapshot.val()
    if(data){
      this.$el.find('.column-entries').html(data.entries)
    }
  }

}

var modules = $('#the-list tr')
modules.each((index, el) => {
  new AdminPoll({el:el})
})

