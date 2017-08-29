<template>
  <div class="container">
    <h1>Patches</h1>

    <table>
      <thead>
        <tr>
          <th>Version</th>
          <th>Main Version</th>
          <th>Started At</th>
          <th>Ended At</th>
        </tr>
      </thead>
      <tr v-for="patch in patches">
        <td>
          <input v-model="patch.version">
        </td>
        <td>
          <input v-model="patch.main_version">
        </td>
        <td>
          <datepicker v-model="patch.started_at"></datepicker>
        </td>
        <td>
          <datepicker v-model="patch.ended_at"></datepicker>
        </td>
      </tr>
    </table>

    <a href="#addPatch" class="button text-center" v-on:click="addPatch">Add a Patch</a>
    <a href="#submitData" class="button text-center" v-on:click="submitData">Submit Data</a>

    <div class="text-center form-success-message" v-on:click="removeSuccessMessage" v-if="thanksMessageVisible === true">
      ty bro. your data has been submitted.
    </div>
  </div>
</template>

<style>
  table{
    width: 100%;
    /*background: #fff;*/
    color: #fff;
  }

  .vdp-datepicker{
    color: #000;
  }
</style>

<script>
  export default {
    mounted() {
      this.getPatches();
    },
    data() {
      return {
        patches: [],
        thanksMessageVisible: false,
      };
    },
    methods: {
      getPatches() {
        this.$http.get(`${window.Laravel.apiUrl}/patches`).then((response) => {
          // success callback
            _.forOwn(response.body, (item) => {
                console.log(item);
                this.patches.push(item);
            });
        });
      },
      addPatch() {
        console.log(this.patches);

        this.patches.push({
            version: '',
            main_version: '',
            started_at: '',
            ended_at: ''
        });
      },
      removeSuccessMessage() {
          this.thanksMessageVisible = false;
      },
      submitData() {
        this.$http.post(`${window.Laravel.apiUrl}/patches`, { patches: this.patches });

          this.thanksMessageVisible = true;

          setInterval(this.removeSuccessMessage, 10000);
      },
    },
  };
</script>
