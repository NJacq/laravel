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
                            <router-link v-bind:to="`/commune/${arrondissement.commune_id}`"><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>                       
                            <h5 class="col-xl-11">                              
                                <small class="text-muted">Arrondissement</small><br>
                                {{arrondissement.nom_arrondissement}}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>A {{arrondissement.nom_arrondissement}}, il y a <strong>{{arrondissement.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et <strong>{{arrondissement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                        soit un total de <strong>{{arrondissement.logements + arrondissement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong></p>
                                                        
                        <!-- <table class="table table-striped table-sm table-bordered" v-if="arrondissement.logements>0">                 
                            <thead class="table-primary">          
                                <tr>                                              
                                    <th>Logements</th>
                                    <th>Établissements</th>                                          
                                   
                                </tr>
                            </thead>
                            <tbody>   
                                <tr> 
                                    <td>{{arrondissement.logements}}</td>
                                    <td>{{arrondissement.etablissements}}</td>                                                                                       
                                </tr>          
                            </tbody>
                        </table>                    -->
                        Pourcentage de locaux raccordables (sur {{arrondissement.logements + arrondissement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                        <table class="table table-striped table-sm table-bordered" v-if="arrondissement.fttharrondissements>[]">                                             
                            <thead class="table-primary">                                      
                                <tr>
                                    <th>Période</th>                                                                              
                                    <th>Locaux raccordables</th>
                                    <th>Pourcentage</th>                 
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-bind:key="fttharrondissement.id" v-for="fttharrondissement in orderBy(arrondissement.fttharrondissements, 'annee', 'trimestre', -1)">   
                                    <td>  
                                        {{fttharrondissement.trimestre}}<sup>{{fttharrondissement.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{fttharrondissement.annee}}    
                                    </td> 
                                    <td>     
                                        {{fttharrondissement.locaux_raccordables | currency('', 0, { thousandsSeparator: ' ' })}}
                                    </td> 
                                     <td>            
                                        {{fttharrondissement.pourcentage}}
                                    </td>
                                </tr>          
                            </tbody>
                        </table>                      
                        <table v-else>Données indisponibles</table>
                    </div>
                    <!-- <router-link class="" v-bind:to="`/arrondissement/${arrondissement.id}/chart`">Voir le graphique</router-link> -->
                     <div class="card-footer">                        
                        <router-link class="" v-bind:to="`/`"><button type="button" class="btn btn-primary">Retour à l'accueil</button></router-link> 
                        <router-link class=""  v-bind:to="`/commune/${arrondissement.commune_id}`"><button type="button" class="btn btn-primary">Retour à la commune {{commune.nom_commune}}</button></router-link> 
                    </div>
                </div>
            </div>
        </div>
    </div>   
</template>
  
<script>
    import axios from 'axios'


    export default {
      
        name: 'Arrondissement',
        data () {
            return {                
                arrondissement:{},
                fttharrondissements:{},
                commune:{}
               
            }
        },
        created () {
            this.isLoading = true;
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/arrondissements/'+ this.id)
            .then(response => {                
                this.arrondissement = response.data
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