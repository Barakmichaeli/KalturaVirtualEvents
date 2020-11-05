<template>
    <div>
        <app-header v-bind:isLoading="isLoadingEntries" v-on:search="search" v-on:clearSearch="clearSearch"></app-header>
        <entries-grid v-bind:isLoading="isLoadingEntries" v-bind:entries="gridEntries"></entries-grid>
        <div v-if="isLoadingEntries" class="py-5" style="text-align: center;">
            <vue-loaders name="ball-beat" color="#4c637b" scale="1.1"
                         style="align-items: center">
            </vue-loaders>
        </div>
    </div>
</template>
<script>
    import AppHeader from '../components/Header'
    import EntriesGrid from '../components/Entries/EntriesGrid'
    export default {
        name: 'Entries',
        data() {
          return {
              isLoadingEntries: true,
              entries: [],
              cachedEntries: []
          }
        },
        mounted() {
            this.loadEntries();
        },
        components: {
            EntriesGrid,
            AppHeader
        },
        computed: {
            gridEntries() {
                return this.entries;
            }
        },
        methods: {
            loadEntries() {
                this.isLoadingEntries = true;
                this.$axios.get('/entries/getLatest').then(response => {
                    this.entries = response.data.entries;
                    this.cachedEntries = this.entries;
                    this.isLoadingEntries = false;
                }).catch(err => {
                    alert("Unknown error occurred, please try again later...")
                    this.isLoadingEntries = false;
                })
            },
            search(keyword) {
                if (this.isLoadingEntries) {
                    return;
                }
                this.isLoadingEntries = true;
                this.$axios.get('/entries/searchLatestEntry?keyword=' + keyword).then(response => {
                    if (this.isLoadingEntries) {
                        this.entries = response.data.results;
                        this.isLoadingEntries = false;
                    }
                }).catch(err => {
                    alert("Unknown error occurred, please try again later...")
                    this.isLoadingEntries = false;
                })
            },
            clearSearch() {
                this.isLoadingEntries = false;
                this.entries = this.cachedEntries;
            }
        }
    }
</script>