<template>
  <table class="table is-fullwidth">
  <thead>
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th><i class="fas fa-plus"></i></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(entry, index) in entries" :key="index">
      <td> {{ entry.first_name }} </td>
      <td> {{ entry.last_name }} </td>
      <td> {{ entry.phone }} </td>
      <td> {{ entry.email }} </td>
      <td></td>
    </tr>
  </tbody>
</table>
</template>

<script>
export default {
  data() {
    return {
      entries : [
        {first_name : "cool", last_name: "beans", phone : "9148133697", email: "test@test.com"},
        {first_name : "cool", last_name: "beans", phone : "9148133697", email: "test@test.com"},
      ]
    }
  }
}
</script>

<style>

</style>
