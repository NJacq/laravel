<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center" v-show="isLoading">
                    <div class="card-body p-5">
                        <i class="fas fa-3x fa-sync fa-spin"></i>
                    </div>
                </div>
                <div class="card card-default" v-show="!isLoading">
                    <div class="card-header">
                        <div class="row">
                            <router-link v-bind:to="`/`"><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>                       
                            <h5 class="col-xl-11">
                            <small class="text-muted">Régions</small><br>
                            Toutes les régions
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div>
                                    <p>Plus forte progression sur les 3 derniers trimestres</p>
                                    <ul>
                                        <li v-bind:key="statregion.id" v-for="statregion in statregions">                               
                                            <strong><router-link class="" v-bind:to="`/region/${statregion.region.id}`">{{statregion.region.nom_region}}</router-link></strong> -> <strong>{{statregion.pourcentage_progression}}%</strong> 
                                        </li> 
                                    </ul> 
                                    <p>Plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                                    <ul>     
                                        <li v-bind:key="ftthtopregion.id" v-for="ftthtopregion in ftthtopregions">
                                    
                                            <strong><router-link class="" v-bind:to="`/region/${ftthtopregion.region.id}`">{{ftthtopregion.region.nom_region}}</router-link></strong> -> <strong>{{ftthtopregion.pourcentage}}</strong>
                                        </li> 
                                    </ul> 
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 liste">
                                <v-select label="nom_region" @input='onSelectRegions' :options="regions" placeholder="Choisir une région">
                                    <span slot="no-options">Aucune région trouvée!</span>
                                </v-select>
                            </div> 
                        </div>
                    </div>
                    <div class="card-footer">
                        <router-link class="col-xl-6" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>

    import axios from 'axios'
    export default {
        methods:{
            onSelectRegions(region) {
                this.$router.push({ path: '/region/' + region.id })
            },
        },
        name: 'Regions',
        data () {
            return {
                regions: [], 
                ftthtopregions: [],
                statregions: []
            }
        },
        created () {
            this.isLoading = true  
            this.id = this.$route.params.id  
            axios.get('http://localhost:8000/api/regions')
            .then(response => {
                this.regions = response.data
            })
            .catch(Err => {
                // console.log(err)
            })
            axios.get('/api/ftthregions?trimestre=1&annee=2018')
            .then(response => {
                this.ftthtopregions = response.data
            })
            axios.get('/api/stattopregions/')
            .then(response => {
                this.statregions = response.data
                this.isLoading = false
            })
        }
    }
</script>
<style scoped>
</style>