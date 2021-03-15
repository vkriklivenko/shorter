<template>
    <section class="jumbotron text-center mt-5">
        <div class="container">
            <h1 class="jumbotron-heading">URL Shorter</h1>
            <p class="lead text-muted">URL shortening is a technique on the World Wide Web in which a Uniform Resource Locator (URL) may be made substantially shorter and still direct to the required page. This is achieved by using a redirect which links to the web page that has a long URL.</p>
        </div>
        <div class="row">
            <div v-if="errors">
                <div v-for="error in errors" class="alert alert-danger" role="alert">
                    <p v-for="item in error">
                        {{item}}
                    </p>
                </div>
            </div>
            <div class="col-md-6 offset-md-3">
                <form v-on:submit.prevent="short()">
                    <div class="form-group row">
                        <label for="input_url" class="col-sm-2 col-form-label col-form-label-sm">Your URL:</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="url" class="form-control form-control-sm" id="input_url" placeholder="Enter URL">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Shorten</button>
                </form>
            </div>
            <div v-if="shorted" class="mt-4">
                <span v-if="isCopied" class="text-success">Copied to clipboard!</span>
                <h3 id="shorted"><a :href="shorted" target="_blank">{{shorted}}</a></h3><button class="btn btn-link" @click="copyUrl()">Copy</button>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                url: null,
                shorted: null,
                errors: [],
                isCopied: false
            }
        },
        methods: {
            short() {
                let vm = this
                axios.post('/api/link', {url: vm.url})
                    .then(function (response) {
                        vm.shorted = response.data
                    })
                    .catch(function (error) {
                        console.log(error.response.data)
                        vm.errors = error.response.data.errors
                        setTimeout(vm.hideErrors, 5000);
                    })
            },
            hideErrors() {
                this.errors = []
            },
            copyUrl() {
                const el = document.createElement('textarea')
                el.value = this.shorted
                document.body.appendChild(el)
                el.select()
                document.execCommand('copy')
                document.body.removeChild(el)
                this.isCopied = true
            }
        }
    }
</script>