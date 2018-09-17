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
                         <h5>
                            <i class="fas fa-map-marker"></i> {{commune.nom_commune}} <small class="text-muted">commune</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p>Dans la commune {{commune.nom_commune}}, on dénombre <strong>{{commune.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et <strong>{{commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                        soit un total de <strong>{{commune.logements + commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong></p>
                    
                        Pourcentage de locaux raccordables (sur {{commune.logements + commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                        <table class="table table-striped table-sm table-bordered" v-if="commune.ftth_communes>[]">                                              
                            <thead class="table-primary">                                      
                                <tr>
                                    <th></th>                                                                              
                                    <th>Locaux raccordables</th>
                                    <th>Pourcentage</th>                 
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-bind:key="ftthcommune.id" v-for="ftthcommune in orderBy(commune.ftth_communes, 'annee', 'trimestre', -1)">   
                                    <td>     
                                       
                                                {{ftthcommune.trimestre}} {{ftthcommune.annee}} 
                                    </td> 
                                    <td>     
                                       
                                                {{ftthcommune.locaux_raccordables | currency('', 0, { thousandsSeparator: ' ' })}}
                                    </td> 
                                    <td>     
                                       
                                                {{ftthcommune.pourcentage}}
                                    </td>
                                </tr>          
                            </tbody>
                        </table>
                        <p v-else>Pas de données disponibles</p>

                        <div class="row" v-if="commune.arrondissements>[]">
                            <div class="col-xl-6 col-md-6 carte">
                            </div>
                            <div class="col-xl-6 col-md-6 liste">                                    
                                <v-select label="nom_arrondissement" @input='onSelectArrondissement' :options="commune.arrondissements" placeholder="Arrondissements">
                                    <span slot="no-options">Aucun résultat</span>
                                </v-select>
                            </div>
                        </div>
                                                
                    </div>
                    <!-- <router-link class="" v-bind:to="`/commune/${commune.id}/chart`">Voir le graphique</router-link> -->
                    <div class="card-footer" v-if="commune.epci">                        
                        <router-link class=""  v-bind:to="`/departement/${commune.departement_id}`">
                            <button type="button" class="btn btn-primary">Retour au département {{commune.departement.nom_epci}}</button>
                        </router-link>
                        <router-link class=""  v-bind:to="`/epci/${commune.epci_id}`" v-if="commune.epci>[]">
                            <button type="button" class="btn btn-primary">Retour à l'epci {{commune.epci.nom_epci}}</button>
                        </router-link>
                        <router-link class=""  v-bind:to="`/epci/${commune.epci_id}`" v-else></router-link> 
                        <router-link class="" v-bind:to="`/`">
                            <button type="button" class="btn btn-primary">Retour à l'accueil</button>
                        </router-link> 
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
            onSelectArrondissement(arrondissement) {
                //console.log(epci.id);
                this.$router.push({ path: '/arrondissement/' + arrondissement.id })
            }, 
        },      
        name: 'Commune',
        data () {
            return {
                commune: {}               
            }
        },
        created () {
            this.isLoading = true;     
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/communes/'+ this.id)
            .then(response => {
                this.commune = response.data   
                this.isLoading = false;     
                
            })
            .catch(Err => {
                // console.log(err)
            })         
        },
    }
    
   
</script>

<style scoped>
    
</style>