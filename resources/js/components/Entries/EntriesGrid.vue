<template>
    <div>
        <table id="entries-grid" class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Thumbnail</th>
                <th scope="col">Name</th>
                <th scope="col">Entry ID</th>
                <th scope="col">Duration</th>
                <th scope="col" class="sorting">Created&nbsp;
                    <i class="fa fa-sort"
                       @click="toggleCreationSorting"
                       style="cursor: pointer"
                       title="Click for changing creation time order">
                    </i>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody v-if="!isLoading">
                <tr v-if="pageEntries.length === 0">
                    <td colspan="7" class="center py-4" style="text-align: center">
                        <h6>No entries available...</h6>
                    </td>
                </tr>
                <entry-row v-for="(entry, idx) in pageEntries" v-bind:entry="entry" :key="idx"></entry-row>
            </tbody>
        </table>
        <div v-if="!isLoading" class="grid-footer px-5">
            Showing
            <input type="text" maxlength="2" size="1" style="text-align: center" v-model="newEntriesPerPage">
            out of {{entries.length}} entries
            <nav v-if="!isLoading && pageEntries.length > 0">
                <ul class="pagination justify-content-center">
                    <li :class="['page-item', currentGridPage === 1 ? 'disabled' : '']">
                        <a class="page-link" href="javascript:;" @click="moveToPage(currentGridPage - 1)">
                            <span>&laquo;</span>
                        </a>
                    </li>
                    <li v-for="i in getPagesCount()" :class="['page-item', currentGridPage === i ? 'active' : '']">
                        <a class="page-link" href="javascript:;" @click="moveToPage(i)">{{i}}</a>
                    </li>
                    <li class="page-item" :class="['page-item', currentGridPage === getPagesCount() ? 'disabled' : '']">
                        <a class="page-link" href="javascript:;" @click="moveToPage(currentGridPage + 1)">
                            <span>&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    import EntryRow from './EntryRow';
    export default {
        name: 'EntriesGrid',
        props: ['entries', 'isLoading'],
        data() {
          return {
              creationSortingDirection: "ASC",
              currentGridPage: 1,
              entriesPerPage: 5, //default number, we can let users to change it and display more entries per page...
              newEntriesPerPage: 5,
          }
        },
        components: {
            EntryRow,
        },
        computed: {
          pageEntries() {
              if (!this.entries) {
                  return [];
              }
              if (this.newEntriesPerPage !== this.entriesPerPage) {
                  if (this.newEntriesPerPage === "") {
                      this.newEntriesPerPage = 0;
                  } else {
                      if (!Number.isInteger(this.newEntriesPerPage)){
                          this.newEntriesPerPage = this.newEntriesPerPage - 0;
                          if (isNaN(this.newEntriesPerPage)) {
                              this.newEntriesPerPage = 0;
                          }
                      }
                  }
                  this.entriesPerPage = this.newEntriesPerPage;
                  this.currentGridPage = 1;
              }
              let start = parseInt(this.entriesPerPage) * parseInt((this.currentGridPage - 1));
              return this.entries.slice(start, parseInt(start) + parseInt(this.entriesPerPage));
          }
        },
        watch: {
            isLoading(oldVal, newVal) {
                if (newVal) {
                    this.currentGridPage = 1;
                }
            }
        },
        methods: {
            toggleCreationSorting() {
                this.creationSortingDirection = this.creationSortingDirection === "ASC" ? "DESC" : "ASC";
                let sortingFunction = this.creationSortingDirection === "ASC" ?
                    (a,b) => (a.created > b.created) ? 1 : ((b.created > a.created) ? -1 : 0) :
                    (a,b) => (a.created < b.created) ? 1 : ((b.created < a.created) ? -1 : 0);
                this.entries = this.entries.sort(sortingFunction);
            },
            getPagesCount() {
                return Math.ceil(this.entries.length / this.entriesPerPage);
            },
            moveToPage(pageIndex) {
                this.currentGridPage = pageIndex;
            }
        }
    }
</script>