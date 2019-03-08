<template>
  <div class="app">
    <div class="app-body">
      <b-row class="justify-content-md-center">
        <b-nav>
          <b-nav-item @click="allContacts()" active>All contacts</b-nav-item>
          <b-nav-item @click="myFavorites()">My favorites</b-nav-item>
        </b-nav>
      </b-row>
      <main class="main">
        <div class="container-fluid">

          <b-row class="justify-content-md-center">
            <b-col col lg="6">
              <v-select label="full_name" :filterable="false" :on-change="onSelectContact" :options="contacts" @search="getContacts">
                <template slot="no-options">
                  type to search contacts
                </template>
                <template slot="option" slot-scope="contact">
                  <div class="d-center">
                    {{ contact.full_name }}
                    </div>
                </template>
              </v-select>

            </b-col>
          </b-row>

          <b-row class="justify-content-md-center">
            <div class="contacts">
              <b-card-group deck>
                <b-card v-if="!favorite" border-variant="light" class="text-center" @click="addContact">
                  <b-card-text>Add new</b-card-text>
                </b-card>

                <b-card v-for="contact in contacts" :key="contact.id"
                @click="viewContact(contact.id)"
                title="Img" 
                :img-src="contact.full_path_profile_photo"
                img-alt="Contact"
                img-top
                tag="article"
                style="max-width: 20rem;"
                class="mb-2">
                  <p class="card-text">
                      {{ contact.full_name }}
                  </p>
                </b-card>
              </b-card-group>
            </div>
          </b-row>

        </div>
      </main>
    </div>
  </div>
</template>

<script>
import vSelect from 'vue-select'
export default {
  components: {
    vSelect
  },
  data () {
    return {
      favorite: false,
      contacts: [],
      selectedContact: null,
      isLoading: false
    }
  },

  mounted () {
    this.getContacts()
  },

  methods: {
    getContacts(query) {
      let params = {favorite: this.favorite}
      if(query) params.search = query
      axios
        .get('/contacts', {params: params})
        .then(response => {
          console.log(response.data)
          this.contacts = response.data.data
        })
        .catch((error) => {
          console.log(error)
        })
    },

    allContacts() {
      this.favorite = false
      this.clearAll()
      this.getContacts()
    },

    myFavorites() {
      this.favorite = true
      this.clearAll()
      this.getContacts()
    },

    onSelectContact(contact) {
      if(contact) {
        this.getContacts(contact.id)
      }
      else {
        this.getContacts()
      }
    },

    clearAll() {
      this.selectedContact = null
    },

    addContact() {
      this.$router.push({ name: 'ContactAdd' })
    },

    viewContact(id) {
      this.$router.push({ name: 'ContactEdit', params: {contactId: id} })
    }
  }
}
</script>
<style>
.contacts {
  margin-top: 50px
}
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
