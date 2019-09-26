
new Vue({
    el: '#app',
    data: {
      fields: [{ first: '',last: '' }],
      msg: ''
    },
    created: function() {
    },
    methods: {
      AddField: function () {
        this.fields.push({ first: '',last: '' });
      },
      RemoveField: function(index){
        this.fields.splice(index, 1);
      },
      autoComplete: function(){
          console.log('as')
          this.results = []
          axios.get('/dahana/perjalanan/json?term=',{params: {query: this.query}}).then(response => {
            this.results = response.data;
        });
      }
    }
  });



  