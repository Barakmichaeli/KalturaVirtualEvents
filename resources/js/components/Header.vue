<template>
    <div>
        <nav class="navbar navbar-header navbar-light bg-light sticky-top">
            <div>
                <span class="navbar-brand h1" style="display:flex; align-items: baseline; margin: 0px">
                    <a href="https://corp.kaltura.com/">
                        <img src="https://developer.kaltura.com/homepage/assets/images/Kaltura-logo.png" style="width: 8rem">
                    </a>
                     &nbsp;|&nbsp;<span style="font-size: 0.9rem">Home Assignment (Virtual Events)</span>
                </span>
           </div>
            <div class="form-inline my-2 my-lg-0 ">
                <input class="form-control mr-sm-2" v-model="keyword" type="search" placeholder="Search for Keyword">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit" @click="search">Search</button>
            </div>
        </nav>
        <div class="py-5 text-center">
            <h2>ENTRIES</h2>
            <p class="lead" style="margin: 0px">List of latest 20 media entries from my Kaltura account (Barak Michaeli)</p>
            <a style="font-size: 10px;color: #17a2b8"
               href="https://mail.google.com/mail/?view=cm&fs=1&to=barak6546@gmail.com" target="_blank">
                Your opinion is important to me! Email me barak6546@gmail.com
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Header',
        props: ['isLoadingEntries'],
        data() {
          return {
              keyword: ''
          }
        },
        watch: {
          keyword(newKeyword, oldKeyword) {
              if (newKeyword === '' && oldKeyword !== '') {
                  this.$emit('clearSearch');
              }
          }
        },
        methods: {
            search(){
                if (this.keyword === '')  {
                    return;
                }
                this.$emit('search', this.keyword);
            }
        }
    }
</script>