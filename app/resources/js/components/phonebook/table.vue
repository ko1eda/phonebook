<template>
  <div>
    <!-- Header and submit button -->
    <div class="tw-flex tw-w-full tw-items-center tw-justify-between tw-mb-1">
      <h1 class="tw-text-indigo">Entries</h1>

      <button 
        v-if="editing || adding"
        class="button is-small tw-bg-indigo tw-text-white"
        @click="editing ? submitEdit : submitEntry">Submit</button>
    </div>

    <!-- Begin table -->
    <table class="table is-fullwidth">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
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
        <td> <input class="input is-small" type="text" placeholder="Text input" v-model="form.first_name"></td>
        <td> <input class="input is-small" type="text" placeholder="Text input" v-model="form.last_name"> </td>
        <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.phone"></td>
        <td><input class="input is-small" type="text" placeholder="Text input" v-model="form.email"></td>
        <td><span @click="cancel"><a class="delete is-small tw-bg-red"></a></span></td>
      </tr>
  
    </tbody>
  </table>
</div>
</template>

<script>
export default {
  data() {
    return {
      entries : [
        {first_name : "cool", last_name: "beans", phone : "9148133697", email: "test@test.com"},
        {first_name : "fool", last_name: "beans", phone : "9148133697", email: "test@test.com"},
      ],
      adding : false,
      editing : false,
      editingIndex: null,

      form : {
        first_name : "",
        last_name : "",
        phone : "",
        email : "",
      }
    }
  },

  methods : {
    // Removes the object at a given index by merging the two halfs of the array split at the given index.
    removeAtIndex(index, id) {
      let fhalf = this.entries.slice(0, index);

      let shalf = this.entries.slice(index + 1);

      this.entries = fhalf.concat(shalf);

      // have this function take an ID paramater
      // axios.delete(/id)
    },

    add() {
      this.adding = true;
    },

    // open the editor at the given index
    editAtIndex(index, id) {
      this.editing = true;
      this.editingIndex = index;
    },
    
    // cancel any editing that has been done
    cancel() {
      this.adding = false;

      this.editing = false;

      this.editingIndex = null;

      // reset the form 
      this.form = {
        first_name : "",
        last_name : "",
        phone : "",
        email : "",
      };
    },

    submitEdit() {
      // axios call to editing endpoint
    },

    submitEntry() {
      // axios call to submit endpoint
    },
  }
}
</script>

<style>

</style>
