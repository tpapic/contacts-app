<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group mb-0">
            <div class="card p-4">
              <div class="card-body">
                <form>
                  <h1 class="title">Contact list app</h1>
                  <p class="text-muted">Sign In to your account</p>
                  <div class="input-group mb-3">
                    <span class="input-group-addon"><i class="icon-user"></i></span>
                    <input type="email" class="form-control" v-model="email" placeholder="Email">
                  </div>
                  <div class="input-group mb-4">
                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                    <input type="password" class="form-control" v-model="password" placeholder="Password">
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button type="submit" class="btn btn-primary px-4" @keyup.enter.prevent="login"  @click="login">Login</button>
                    </div>
                  </div>
                </form>
                <div class="error-message">
                  <b-alert variant="danger"
                    dismissible
                    :show="errorMessageAlert"
                    @dismissed="errorMessageAlert = false">
                    {{ errorMessage }}
                  </b-alert>
                </div>
                <p class="info">Tomislav Papic All Rights Reserved</p>
              </div>
            </div>
            <div class="card text-white bg-logo py-5 d-md-down-none" style="width:44%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {

  data () {
    return {
      email: null,
      password: null,
      errorMessageAlert: false,
      errorMessage: ''
    }
  },
  methods: {
    login (e) {
      e.preventDefault()
      let socialId = 1
      let params = {social_provider_id: socialId ,email: this.email, password: this.password }
      axios
        .post('/auth/login', params)
        .then(response => {
          if (response.data.success === true) {
            this.$store.dispatch('setUser', response)
            this.$router.push('/')
          } else {
            this.errorMessage = response.data.messages
            this.errorMessageAlert = true
          }
        })
        .catch(() => {
          this.errorMessage = 'Internal error'
          this.errorMessageAlert = true
        })
    }
  }

}
</script>
<style lang="scss">
  .info {
    margin: 0;
    position: absolute;
    bottom: 0;
    color: #7e878c;
  }
  .title {
    font-size: 1.68rem;
  }
  .error-message {
    height: 68px;
    padding-top: 10px;
  }
</style>
