<template>
  <Table :props-data="entries"/>
</template>

<script>
import Table from "../../components/phonebook/table"
export default {
  components : {
    Table
  },

  data () {
    return {
      entries : []
    }
  },

  // Whenever the page is loaded, fetch all entries from the database
  mounted() {
    axios.get("/phonebook")
      .then(({data}) => this.entries = data.data)
      .catch(error => console.log(error));
  }

}
</script>

<style>

</style>
