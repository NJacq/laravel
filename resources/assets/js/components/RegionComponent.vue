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
                            <router-link v-bind:to="`/regions`"><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>
                            <h5 class="col-xl-11">
                                <small class="text-muted">Région</small><br>
                                {{region.nom_region}}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-sm table-bordered" v-if="region.ftthregions>[]">
                            <thead class="table-secondary">                                      
                                <tr>
                                    <th>Période</th>
                                    <th>
                                        Pourcentage de locaux raccordables (sur {{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-bind:key="ftthregion.id" v-for="ftthregion in orderBy(region.ftthregions, 'annee', 'trimestre', -1)">
                                    <td>
                                        {{ftthregion.trimestre}}<sup>{{ftthregion.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{ftthregion.annee}}
                                    </td>
                                    <td>
                                        {{ftthregion.pourcentage}}
                                        <small class="text-muted">({{ftthregion.nombre_locaux | currency('', 0, { thousandsSeparator: ' ' })}} locaux)</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  
                        <p class="text-justify" v-if="region.etablissements > 1">
                        <small>En région {{region.nom_region}}, il y a 
                        <strong>{{region.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong>
                        et
                        <strong>{{region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                        soit un total de <strong>{{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                        </small>
                        </p>
                        <p class="text-justify" v-else-if="region.etablissements > 0">
                        <small>En région {{region.nom_region}}, il y a 
                        <strong>{{region.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                        <strong>{{region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissement</strong>
                        soit un total de <strong>{{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                        </small>
                        </p>
                        <p class="text-justify" v-else>
                        <small>En région {{region.nom_region}}, il y a 
                        <strong>{{region.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                        <strong> aucun établissement</strong>
                        soit un total de <strong>{{region.logements + region.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                        </small>
                        </p>
       
                        <div col-md-12 col-xl-12 v-if="region.ftthregions>[]">
                            Pourcentage de locaux raccordables par nombre d'opérateurs
                            <table class="table table-striped table-sm table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Période</th>
                                        <th>Au moins un opérateur</th>
                                        <th>Au moins deux opérateurs</th>
                                        <th>Au moins trois opérateurs</th>
                                        <th>Au moins quatre opérateurs</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <tr v-bind:key="ftthregion.id" v-for="ftthregion in orderBy(region.ftthregions, 'annee', 'trimestre', -1)">                       
                                        <td>                                                                                                                                 
                                            {{ftthregion.trimestre}}<sup>{{ftthregion.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{ftthregion.annee}}
                                        </td>
                                        <td>                                                                                                          
                                            {{ftthregion.unoperateur}} 
                                        </td>  
                                        <td>                                                                                                                                 
                                          {{ftthregion.deuxoperateurs}} 
                                        </td>  
                                        <td>                                                                                                                                  
                                            {{ftthregion.troisoperateurs}}                             
                                        </td>  
                                        <td>                                                                                                                              
                                            {{ftthregion.quatreoperateurs}} 
                                        </td>             
                                    </tr>
                                </tbody>                               
                            </table>                                
                        </div>
                        <div class="col-md-12 col-xl-12" v-else>
                            <p>Données indisponibles</p>                                
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div v-show="statdepartements.length>0">
                                    <p>Plus forte progression sur les 3 derniers trimestres</p>
                                    <ul>
                                        <li v-bind:key="statdepartement.id" v-for="statdepartement in statdepartements" v-if="statdepartement.pourcentage_progression>0">
                                        <strong><router-link class="" v-bind:to="`/departement/${statdepartement.departement.id}`">{{statdepartement.departement.nom_departement}}</router-link></strong> -> <strong>{{statdepartement.pourcentage_progression}}%</strong>
                                    </li>
                                    </ul>
                                </div>
                                <div v-show="ftthtopdepartements.length>0">
                                    <p>Plus fort pourcentage de locaux raccordables au dernier trimestre.</p>                                    
                                    <ul>     
                                        <li v-bind:key="ftthtopdepartement.id" v-for="ftthtopdepartement in ftthtopdepartements">                               
                                            <strong><router-link class="" v-bind:to="`/departement/${ftthtopdepartement.departement.id}`">{{ftthtopdepartement.departement.nom_departement}}</router-link></strong> -> <strong>{{ftthtopdepartement.pourcentage}}</strong>
                                        </li> 
                                    </ul> 
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <v-select label="nom_departement" @input='onSelectDepartements' :options="departements" placeholder="Choisir un département">
                                    <span slot="no-options">Aucun département trouvé!</span>
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
            onSelectDepartements(departements) {               
                this.$router.push({ path: '/departement/' + departements.id })
            },
        },
        name: 'Region',
        data () {            
            return {                                 
                region: [], 
                statdepartements: [],
                ftthtopdepartements: [],
                departements:[]                
            }               
        },      
        created () {  
            this.isLoading = true       
            this.id = this.$route.params.id  
                  
            axios.get('api/region/'+ this.id)   
            .then(response => {
                this.region = response.data
                console.log(this.region.departements)
            }),
            axios.get('api/departements/region/'+ this.id)   
            .then(response => {
                this.departements = response.data
                console.log(this.departements)
            }),
            axios.get('api/stattopdepartements/region/' + this.id)   
            .then(response => {
                this.statdepartements = response.data         
            }),

            axios.get('api/ftthtopdepartements/region/' + this.id)
               .then(response => {
                this.ftthtopdepartements = response.data           
                this.isLoading = false            
            })            
        }
    }
    
</script>
<style scoped>
    
</style>
