<template>
  <div class="app">
    <div class="app-body">
      <div class="container-fluid">
        
      </div>
      <main class="main">
        <div class="container-fluid">
          <b-row class="justify-content-md-center">
            <div class="add-contact">
              <button @click="back">Back</button>
              <button @click="editMode">Toggle edit mode</button>
              <button @click="deleteContact">Delete</button>
            </div>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <b-col sm="3">
              <label for="first-name">First name</label>
            </b-col>
            <b-col col lg="6">
              <b-form-input :disabled="disabledInputs" id="first-name" v-model="contact.first_name" type="text" placeholder="Enter your first name" />
            </b-col>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <b-col sm="3">
              <label for="first-name">Last name</label>
            </b-col>
            <b-col col lg="6">
              <b-form-input id="last-name" :disabled="disabledInputs" v-model="contact.last_name" type="text" placeholder="Enter your last name" />
            </b-col>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <b-col sm="3">
              <label for="email">Email</label>
            </b-col>
            <b-col col lg="6">
              <b-form-input id="email" :disabled="disabledInputs" v-model="contact.email" type="text" placeholder="Enter your email" />
            </b-col>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <div class="numbers">
              <ul>
                <li v-for="(number, index) in contact.numbers" :key="index">
                <input :disabled="disabledInputs" type="text" v-model="number.label">
                <input :disabled="disabledInputs" type="text" v-model="number.number">
                <button v-if="!disabledInputs" @click="deleteRow(index)">Delete</button>
                </li>
              </ul>
            </div>
          </b-row>

          <b-row class="justify-content-md-center" v-if="!disabledInputs">
            <div class="add-row">
              <button @click="addRow">Add number</button>
            </div>
          </b-row>

          <b-row v-if="!disabledInputs">
            <div class="add-contact">
              <button @click="editContact">Edit contact</button>
            </div>
          </b-row>

          <b-row class="justify-content-md-center">
            <ul>
              <li v-for="(error, index) in errors" :key="index">{{ error[0] }}</li>
            </ul>
          </b-row>

        </div>
      </main>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      errors: [],
      disabledInputs: true,
      contact: {
        id: this.$route.params.contactId,
        first_name: null,
        last_name: null,
        email: null,
        numbers: [
          { label: '', number: ''}
        ]
      },
    }
  },

  mounted () {
    this.getContact()
  },

  methods: {
    addRow() {
      this.contact.numbers.push({ label: '', number: ''})
    },

    deleteRow(index) {
      this.contact.numbers.splice(index, 1)
    },

    getContact() {
      axios
        .get('/contacts/' + this.contact.id)
        .then(response => {
          console.log(response.data)
          this.contact = response.data.data
        })
        .catch((error) => {
          console.log(error)
        })
    },

    editContact() {
      axios
        .put('/contacts/' + this.contact.id, this.contact)
        .then(response => {
          console.log(response.data)
          if(response.data.success === false) {
            this.errors = response.data.errors
          } else {
            this.errors = []
            //alert("Success");
          }
        })
        .catch((error) => {
          console.log(error)
        })
    },

    deleteContact(contact) {
      if (confirm('Are you sure to delete contact?') && contact) {
        axios
          .delete('/contacts/' + this.contact.id)
          .then(response => {
            console.log(response.data)
            // alert("Success");
            this.back()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },

    back() {
      this.$router.push({ name: 'Contacts' })
    },

    editMode() {
      this.disabledInputs = !this.disabledInputs
    }
  }
}
</script>
<style lang="sass">
.numbers > ul
  list-style-type: none
  li
    margin-top: 5px

.add-row
  display:flaxs
</style>


