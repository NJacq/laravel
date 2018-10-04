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
                        <h5>Le marché du haut et très haut débit fixe (déploiements) en France</h5>                
                    </div>
                    <div class="card-body">                          
                        <p>Vous trouverez ici un suivi des déploiements de la fibre optique jusqu'à l'abonné (Ftth). Les <a target="blank" href="https://www.data.gouv.fr/fr/datasets/le-marche-du-haut-et-tres-haut-debit-fixe-deploiements/">données</a> sont issues de la collecte trimestrielle "Observatoire de gros HD/THD" de l'<a target="blank" href="https://www.arcep.fr/">arcep</a> (Autorité de régulation des communications électroniques et des postes) disponibles sous licence ouverte.</p>
                        <div class="row">
                            <div class="col-xl-6 col-md-6 text-justify">
                                <p>Vous pouvez obtenir directement des informations sur une région, un département ou une commune en saisissant son nom dans le champ correspondant.<br>
                                Vous avez aussi la possibilité de naviguer parmi les différents échelons administratifs en débutant par <router-link v-bind:to='"/regions"'>les régions</router-link>.
                                </p>
                                <p>Liens complémentaires : </p>                              
                                <a target="blank" v-bind:href='"https://cartefibre.arcep.fr/index.html?location=2.75634801353101,46.26238837151979&zoom=5.515479878002048&mode=Dpt"'>Carte de l'arcep des déploiements par départements</a><br>
                                <a target="blank" v-bind:href='"https://cartefibre.arcep.fr/"'>Carte de l'arcep des déploiements par communes</a>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <p><strong>Rechercher...</strong></p>
                                <v-select label="nom_region" @input='onSelectRegion' :options="regions" placeholder="une région">
                                    <span slot="no-options">Aucune région trouvée!</span>
                                </v-select>
                                <br>
                                <v-select label="nom_departement" @input='onSelectDepartement' :options="departements" placeholder="un département">
                                    <span slot="no-options">Aucun département trouvé!</span>
                                </v-select>
                                <br>                  
                                <v-select label="nom_commune" :filterable="false" :options="communes" @search="onSearch" @input='onSelectCommune' placeholder="une commune">
                                    <span slot="selected-option" slot-scope="commune">
                                        <div class="selected d-center">                                    
                                            {{ commune }}
                                        </div>
                                    </span>
                                    <span slot="no-options">Aucune commune trouvée!</span>
                                </v-select>                              
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                       <a target="blank" href="https://www.arcep.fr/"><img class="logo1" src="http://localhost/laravel/resources/assets/media/arcep_logo.png"></a>
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
                communes: []                              
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
                        vm.communes = json
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
            })
            .catch(Err => {
                // console.log(err)
            }),
            axios.get('/api/departements')
            .then(response => {
                this.departements = response.data
                  this.isLoading = false;
            })
        }
    }

</script>

<style>
    .logo1{      
       width: 8%;
   }

</style>