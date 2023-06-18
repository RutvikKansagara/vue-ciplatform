<template>
    <div class="ms-5 me-5 mt-5">
        <div class="ms-5 me-5 mt-5 mb-5 w-25 rounded">

        <router-link :to="`/cmspage/create`" class="p-2 col border btn btn-success">
            <i class="fas fa-plus me-2"></i>Add</router-link></div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">text</th>
                <th scope="col">slug</th>
                <th scope="col">status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="cmspage in cmspages" :key="cmspage.cms_page_id">
                    <td>{{ cmspage.cms_page_id }}</td>
                    <td>{{ cmspage.title }}</td>
                    <td v-html="cmspage.text"></td>
                    <td>{{ cmspage.slug }}</td>
                    <td>{{ getStatusLabel(cmspage.status)  }}</td>
                    <td>
                      <div class="row gap-3">
                        <!-- <router-link :to="`/cmspage/${cmspage.cms_page_id}`" class="p-2 col border btn btn-primary">View</router-link> -->
                        <router-link :to="`/cmspage/${cmspage.cms_page_id}/edit`" class="p-2 col border btn btn-success">Edit</router-link>
                        <button @click="deleteCmsPage(cmspage.cms_page_id)" type="button" class="p-2 col border btn btn-danger">Delete</button>
                      </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      cmspages: []
    }
  },
  async created() {
    try {
      const response = await axios.get('/api/cmspage');
      this.cmspages = response.data;
    } catch (error) {
      console.error(error.response.data);
    }
  },
  methods: {
    getStatusLabel(status) {
    return status === '1' ? 'Active' : 'Inactive';
  },
    async deleteCmsPage(cms_page_id) {
      try {
        await axios.delete(`/api/cmspage/${cms_page_id}`);
        this.cmspages = this.cmspages.filter(cmspage => cmspage.cms_page_id !== cms_page_id);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
