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
                            <i class="fas fa-map-marker"></i> {{epci.nom_epci}} <small class="text-muted">EPCI</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p>Dans l'EPCI {{epci.nom_epci}}, on dénombre <strong>{{epci.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et <strong>{{epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                        soit un total de <strong>{{epci.logements + epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong></p>
                                     
                        Pourcentage de locaux raccordables (sur {{epci.logements + epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                        <table class="table table-striped table-sm table-bordered" v-if="epci.ftthepci>[]">                                             
                            <thead class="table-primary">                                      
                                <tr>
                                    <th></th>                                                                              
                                    <th>Locaux raccordables</th>
                                    <th>Pourcentage</th>                 
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-bind:key="ftthepci.id" v-for="ftthepci in orderBy(epci.ftthepci, 'annee', 'trimestre', -1)"> 
                                    <td>     
                                        {{ftthepci.trimestre}} {{ftthepci.annee}} 
                                    </td> 
                                    <td>     
                                        {{ftthepci.locaux_raccordables | currency('', 0, { thousandsSeparator: ' ' })}}
                                    </td> 
                                     <td>     
                                        {{ftthepci.pourcentage}}
                                    </td>
                                </tr>          
                            </tbody>
                        </table> 
                        <p v-else>Données indisponibles</p>
                        <div class="row">
                            <div class="col-xl-6 col-md-6 carte">
                            </div>
                            <div class="col-xl-6 col-md-6 liste">
                                <v-select label="nom_commune" @input='onSelectCommune' :options="epci.communes" placeholder="Communes">
                                     <span slot="no-options">Aucun résultat</span>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <router-link class=""  v-bind:to="`/departement/${epci.departement_id}`" v-if="epci.departement">
                            <button type="button" class="btn btn-primary">
                                Retour au département {{epci.departement.nom_departement}}
                            </button>
                        </router-link>
                        <router-link class="" v-bind:to="`/`">
                            <button type="button" class="btn btn-primary">
                                Retour à l'accueil
                            </button>
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
            onSelectCommune(commune) {
                //console.log(epci.id);
                this.$router.push({ path: '/commune/' + commune.id })
            },
        },
        name: 'Epci',
        data () {
            return {
                epci: {},
                // communes:[], 
                // ftthepcis: {},
                // departement:{}                             
            }
        },
        created () {
            this.isLoading = true;     
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/epci/'+ this.id)
            .then(response => {
                // console.log(response)
                this.epci = response.data
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