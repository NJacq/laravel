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
                            <small class="text-muted">Département</small><br>
                            <i class="fas fa-map-marker"></i> {{departement.nom_departement}}
                        </h5>           
                    </div>
                    <div class="card-bodyb">
                        <p>Dans le département {{departement.nom_departement}}, il y a <strong>{{departement.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et <strong>{{departement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                        soit un total de <strong>{{departement.logements + departement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong></p>
                        
                        Pourcentage de locaux raccordables (sur {{departement.logements + departement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                        <table class="table table-striped table-sm table-bordered" v-if="departement.ftthdepartements>[]">                                             
                            <thead class="table-primary">                                      
                                <tr>
                                    <th>Période</th>                                                                              
                                    <th>Locaux raccordables</th>
                                    <th>Pourcentage</th>                 
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-bind:key="ftthdepartement.id" v-for="ftthdepartement in orderBy(departement.ftthdepartements, 'annee', 'trimestre', -1)">   
                                    <td>     
                                        {{ftthdepartement.trimestre}}<sup>{{ftthdepartement.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{ftthdepartement.annee}} 
                                    </td> 
                                    <td>   
                                        {{ftthdepartement.nombre_locaux | currency('', 0, { thousandsSeparator: ' ' })}}
                                    </td> 
                                    <td>     
                                        {{ftthdepartement.pourcentage}}
                                    </td>
                                </tr>          
                            </tbody>
                        </table>
                        <p v-else>Données indisponibles</p>
                        <div class="row" v-if="departement.epci>[]">
                            <div class="col-xl-4 col-md-4 carte">                                
                            </div>                            
                            <div class="col-xl-4 col-md-4 liste">                                
                                <v-select label="nom_epci" @input='onSelectEpci' :options="departement.epci" placeholder="EPCI">
                                    <span slot="no-options">Aucun résultat</span>
                                </v-select>
                            </div>
             
                            <div class="col-xl-4 col-md-4 liste">
                                <v-select label="nom_commune" @input='onSelectCommune' :options="departement.communes" placeholder="Communes">
                                    <span slot="no-options">Aucun résultat</span>
                                </v-select>
                            </div> 
                        </div>                     
                        <div class="row" v-else>
                            <div class="col-xl-6 col-md-6 carte">                                
                            </div>                  
                            <div class="col-xl-6 col-md-6 liste">
                                <v-select label="nom_commune" @input='onSelectCommune' :options="departement.communes" placeholder="Communes">
                                    <span slot="no-options">Aucun résultat</span>
                                </v-select>
                            </div>            
                        </div>
                    </div>
                    <!-- <router-link class="" v-bind:to="`/departement/${departement.id}/chart`">Voir le graphique</router-link> -->
                    <div class="card-footer">
                        <router-link v-bind:to="`/region/${departement.region_id}`">
                            <button type="button" class="btn btn-primary" v-if="departement.region">
                                Retour à la région {{ departement.region.nom_region }}
                            </button>
                        </router-link> 
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link> 
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
            onSelectEpci(epci) {
                //console.log(epci.id);
                this.$router.push({ path: '/epci/' + epci.id })
            },
            onSelectCommune(commune) {
                //console.log(epci.id);
                this.$router.push({ path: '/commune/' + commune.id })
            },
        },
        name: 'Departement',
        data () {
            return {
                departement: {},            
            }
        },        
        created () {
            this.isLoading = true;
            this.id = this.$route.params.id
            axios.get('api/departements/'+ this.id)
            .then(response => {
                this.departement = response.data
                this.isLoading = false;                
            })
            .catch(Err => {
                // console.log(err)
            })             
        }
    }       
</script>

<style scoped>

</style>