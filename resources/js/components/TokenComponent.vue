<template>

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Set git token</div>
                    <div class="card-body">
                        <b-form @submit="formSubmit">
                            <b-form-group
                                id="input-group-1"
                                label="Token:"
                                label-for="input-1"
                                description="Insert a generated git token">
                                <b-form-input
                                id="input-1"
                                v-model="form.token"
                                placeholder=""
                                required
                                ></b-form-input>
                            </b-form-group>
                            
                            <b-button type="submit" variant="primary">Submit</b-button>
                        </b-form>
                        <h2>Registered token</h2>
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
                form: {
                token: ''
                },
              info: null,
              name: '',
              description: '',
              output: null,
              token: null
            };
        },
        methods: {
            formSubmit(e) {
              e.preventDefault()
                let currentObj = this;
                
                axios.post('/saveToken',{token: currentObj.form.token})
                .then(function (response) {
                axios.post('/getToken')
                .then(function (response) {
                    currentObj.token = response.data;
                })
                .catch(function (error) {
                    window.alert(error)
                    currentObj.output = error;
                });
                })
                .catch(function (error) {
                    window.alert(error)
                    currentObj.output = error;
                });
               
            }
        }
    }
</script>
