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
            </div>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <b-col sm="3">
              <label for="first-name">First name</label>
            </b-col>
            <b-col col lg="6">
              <b-form-input id="first-name" v-model="contact.first_name" type="text" placeholder="Enter your first name" />
            </b-col>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <b-col sm="3">
              <label for="first-name">Last name</label>
            </b-col>
            <b-col col lg="6">
              <b-form-input id="last-name" v-model="contact.last_name" type="text" placeholder="Enter your last name" />
            </b-col>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <b-col sm="3">
              <label for="email">Email</label>
            </b-col>
            <b-col col lg="6">
              <b-form-input id="email" v-model="contact.email" type="text" placeholder="Enter your email" />
            </b-col>
          </b-row>
          <br>
          <b-row class="justify-content-md-center">
            <div class="numbers">
              <ul>
                <li v-for="(number, index) in contact.numbers" :key="index">
                <input type="text" v-model="number.label">
                <input type="text" v-model="number.number">
                <button @click="deleteRow(index)">Delete</button>
                </li>
              </ul>
            </div>
          </b-row>

          <b-row class="justify-content-md-center">
            <div class="add-row">
              <button @click="addRow">Add number</button>
            </div>
          </b-row>

          <b-row>
            <div class="add-contact">
              <button @click="addContact">Add contact</button>
            </div>
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
      contact: {
        first_name: null,
        last_name: null,
        email: null,
        numbers: [
          { label: '', number: ''}
        ]
      },
    }
  },

  methods: {
    addRow() {
      this.contact.numbers.push({ label: '', number: ''})
    },

    deleteRow(index) {
      this.contact.numbers.splice(index, 1)
    },

    addContact() {
      axios
        .post('/contacts', this.contact)
        .then(response => {
          console.log(response.data)
          alert("Success");
        })
        .catch((error) => {
          console.log(error)
        })
    },

    back() {
      this.$router.push({ name: 'Contacts' })
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


