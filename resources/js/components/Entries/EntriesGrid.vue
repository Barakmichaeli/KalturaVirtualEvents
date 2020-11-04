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
                        <h6>Sorry, no entries available...</h6>
                    </td>
                </tr>
                <entry-row v-for="(entry, idx) in pageEntries" v-bind:entry="entry" :key="idx"></entry-row>
            </tbody>
        </table>
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
              let start = this.entriesPerPage * (this.currentGridPage - 1);
              return this.entries.slice(start, start + this.entriesPerPage);
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