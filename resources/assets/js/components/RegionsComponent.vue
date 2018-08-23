<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Stats arcep par régions</div>

                    <div class="card-body">
                        <ul>
                            <li v-bind:key="region.nom_region" v-for="region in orderBy (regions, 'nom_region')">
                                <router-link class="" v-bind:to="`/region/${region.id}`">{{region.nom_region}}</router-link> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: 'Regions',
        data () {
            return {
                regions: {}              
            }
        },
        created () {
            axios.get('http://localhost:8000/api/regions')
            .then(response => {
                console.log(response)
                this.regions = response.data
                // this.comp = JSON.parse(response.data)
            })
            .catch(Err => {
                // console.log(err)
            })            
        }
    }
</script>
