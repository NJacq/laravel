<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-sm-10">
                <div class="card text-center" v-show="isLoading">               
                    <div class="card-body p-5">
                        <i class="fas fa-3x fa-sync fa-spin"></i>
                    </div>  
                </div>                 
                <div class="card card-default" v-show="!isLoading">
                    <div class="card-header">  
                        <h5>
                            Le marché du haut et très haut débit fixe (déploiements) en France
                        </h5>                
                    </div>
                    <div class="card-body">                          
                        <p>Vous trouverez ici un suivi des déploiements de la fibre optique jusqu'à l'abonné (Ftth). Les données sont issues de la collecte trimestrielle "Observatoire de gros HD/THD" de l'arcep (Autorité de régulation des communications électroniques et des postes).</p>
                        <div class="row">
                            <p class="col-xl-6 col-md-6">Vous pouvez obtenir directement des informations sur une region, un département ou une commune en saisissant son nom dans le champ correspondant.<br>
                            Vous avez aussi la possibilité de naviguer parmi les différents échelons administratifs en débutant par <router-link v-bind:to='"/regions"'>les régions</router-link>.
                            </p>
                            <div class="col-xl-6 col-md-6">
                                <v-select label="nom_region" @input='onSelectRegion' :options="regions" placeholder="Rechercher une région">
                                    <span slot="no-options">Aucune région trouvée!</span>
                                </v-select>
                                <v-select label="nom_departement" @input='onSelectDepartement' :options="departements" placeholder="Rechercher un département">
                                    <span slot="no-options">Aucun département trouvé!</span>
                                </v-select>                  
                                <v-select label="nom_commune" :filterable="false" :options="options" @search="onSearch" @input='onSelectCommune' placeholder="Rechercher une commune">
                                    <span slot="selected-option" slot-scope="option">
                                        <div class="selected d-center">                                    
                                            {{ option }}
                                        </div>
                                    </span>
                                    <span slot="no-options">Aucune commune trouvée!</span>
                                </v-select>                              
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- <router-link v-bind:to='"/regions"'><button type="button" class="btn btn-primary">Accèder à la liste des régions</button></router-link> -->
                        <a target="blank" v-bind:href='"https://cartefibre.arcep.fr/index.html?location=2.75634801353101,46.26238837151979&zoom=5.515479878002048&mode=Dpt"'><button type="button" class="btn btn-primary">Carte des départements de l'arcep</button></a>
                        <a target="blank" v-bind:href='"https://cartefibre.arcep.fr/"'><button type="button" class="btn btn-primary">Carte des communes de l'arcep</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>

import {_} from 'vue-underscore';
import axios from 'axios'
    export default {
        name: 'Home',
        data () {
            return {
                regions: [],
                departements: [],
                options: []                              
            }
        },
        methods:{
            onSelectRegion(region) {
                this.$router.push({ path: '/region/' + region.id })
            },
            onSelectDepartement(departement) {
                this.$router.push({ path: '/departement/' + departement.id })
            },
            onSelectCommune(commune) {
                console.log(commune)
                this.$router.push({ path: '/commune/' + commune.id })
            },
            onSearch(search, loading) {
                loading(true);
                this.search(loading, search, this);
            },
            search: _.debounce((loading, search, vm) => {
                //console.log(search)
                fetch(`/api/communes/search?q=${escape(search)}`)
                .then(res => {
                    res.json().then(json => {
                        console.log(json)
                        vm.options = json
                    });
                    loading(false);
                });
            }, 350)            
        },        
        created () {
            this.isLoading = true  
            this.id = this.$route.params.id  
            axios.get('/api/regions')
            .then(response => {
                this.regions = response.data
                console.log(this.regions)
            })
            .catch(Err => {
                // console.log(err)
            }),
            axios.get('/api/departements')
            .then(response => {
                this.departements = response.data
                  this.isLoading = false;
            }),
            axios.get('/api/communes/search')
            .then(response => {
                this.communesSearch = response.data
              
            })
        }
    }

</script>

<style>
   input{
       height: 35px;
       width: 80%;
   }
</style>