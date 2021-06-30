<template>

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Git token</div>
 
                    <div class="card-body">
                        <form @submit="formSubmit">
                        <strong>Token:</strong>
                        <textarea class="form-control" v-model="description"></textarea>
                        <button class="btn btn-success">Submit</button>
                        </form>
                        <pre>
                        {{output}}
                        </pre>
                        <h2>Token</h2>
  <strong v-if="token">{{ token }}</strong>
  <strong v-else>No Token? Click<a href="https://docs.github.com/en/github/authenticating-to-github/keeping-your-account-and-data-secure/creating-a-personal-access-token"> here </a>to learn how to make token</strong>
                    </div>
                </div>
            </div>
        </div>
</div>

</template>
<script>
    export default {
        mounted() {
                let currentObj = this;
                console.log('Component mounted.')
                axios.post('/getToken')
                .then(function (response) {
                    currentObj.token = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
        },
        data() {
            return {
              info: null,
              name: '',
              description: '',
              output: '',
              token: null
            };
        },
        methods: {
            formSubmit(e) {
              e.preventDefault()
                let currentObj = this;
                
                axios.post('/saveToken',{token: this.description})
                .then(function (response) {
                    currentObj.output = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
                axios.post('/getToken')
                .then(function (response) {
                    currentObj.token = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
                window.alert(this.token)
            }
        }
    }
</script>
