<template>
  <div>
    <!-- Header and submit button -->
    <div class="tw-flex tw-w-full tw-items-center tw-justify-between tw-mb-1">
      <h1 class="tw-text-indigo">Entries</h1>

      <button 
        v-if="editing || adding"
        class="button is-small tw-bg-indigo tw-text-white"
        @click="editing ? submitEdit() : submitEntry()">Submit</button>
    </div>

    <!-- Begin table -->
    <div class="table-container">
      <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>First</th>
          <th>Last</th>
          <th>Phone</th>
          <th>Email</th>
          <th>
            <span @click="add"><i class="fas fa-plus tw-text-green tw-cursor-pointer" alt="add new entry"></i></span>
          </th>
        </tr>
      </thead>
      <tbody>
  
        <!-- Display all entries from entries array, if editing, display a form only for that array -->
        <template v-for="(entry, index) in entries" >
          <tr v-if="index === editingIndex && editing === true" :key="index">
            <td> <input class="input is-small" type="text" placeholder="Text input" v-model="form.first_name"></td>
            <td> <input class="input is-small" type="text" placeholder="Text input" v-model="form.last_name"> </td>
            <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.phone"></td>
            <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.email"></td>
            <td><span @click="cancel"><a class="delete is-small tw-bg-red"></a></span></td>
          </tr>
          <tr v-else :key="index">
            <td> {{ entry.first_name }} </td>
            <td> {{ entry.last_name }} </td>
            <td> {{ entry.phone }} </td>
            <td> {{ entry.email }} </td>
            <td>
              <span @click="editAtIndex(index, entry.id)"><i class="fas fa-edit tw-text-blue tw-cursor-pointer tw-mr-1" alt="add new entry"></i></span>
              <span @click="removeAtIndex(index, entry.id)"><a class="delete is-small tw-bg-red"></a></span>
            </td>
          </tr>
        </template>
  
        <!-- Display a new row to be filled with data if adding === true-->
        <tr v-if="adding">
          <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.first_name"></td>
          <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.last_name"></td>
          <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.phone"></td>
          <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.email"></td>
          <td><span @click="cancel"><a class="delete is-small tw-bg-red"></a></span></td>
        </tr>
    
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      entries : [],
      adding : false,

      editing : false,
      editingIndex: null,
      editingId: null,

      form : {
        first_name : "",
        last_name : "",
        phone : "",
        email : "",
      }
    }
  },

  // Load all entries when the component is mounted to the dom
  mounted() {
    axios.get("/phonebook")
      .then(({data}) => this.entries = data.data)
      .catch(error => flash('Could not load entries', "danger"));
  },

  methods : {
    // Removes the object at a given index by merging the two halfs of the array split at the given index.
    removeAtIndex(index, id) {
      axios.delete(`/phonebook/${id}`)
        .then(() => {
          let fhalf = this.entries.slice(0, index);

          let shalf = this.entries.slice(index + 1);

          this.entries = fhalf.concat(shalf);
        })
        .catch(error => flash('Deletion Error', "danger"))
    },

    // Sets adding to true
    add() {
      // if we are editing or adding already, disable the button
      if (this.editing || this.adding) return;

      this.adding = true;
    },

    // open the editor at the given index
    editAtIndex(index, id) {
      // if we are editing or adding already, disable the button
      if (this.editing || this.adding) return;

      this.editing = true;
      this.editingIndex = index;
      this.editingId = id;

      // Set the form equal to the object we are editing
      this.form = {
        first_name : this.entries[index].first_name,
        last_name : this.entries[index].last_name,
        phone : this.entries[index].phone,
        email : this.entries[index].email
      };
    },
    
    // cancel any editing that has been done and clear form
    cancel() {
      this.adding = false;

      this.editing = false;

      this.editingIndex = null;

      this.clearForm();
    },

    // Submit an edit
    submitEdit() {
      axios.patch(`/phonebook/${this.editingId}`, this.form)
        .then(({data}) => {
          let fhalf = this.entries.slice(0, this.editingIndex);

          fhalf.push(data.data);

          let shalf = this.entries.slice(this.editingIndex + 1);

          this.entries = fhalf.concat(shalf);

          this.cancel()
        })
        .catch(error => flash('Validation Error', "danger"));
    },

    // Submit a new entry
    submitEntry() {
      axios.post("/phonebook", this.form)
        .then(({data}) => {
          this.entries = this.entries.concat(data.data);
          this.cancel()
        })
        .catch(error => flash('Validation Error', "danger"));
    },

    // clear the submission form
    clearForm() {
      this.form = {
        first_name : "",
        last_name : "",
        phone : "",
        email : "",
      };
    }

  }
}
</script>

<style>

</style>
