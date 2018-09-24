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
                            <router-link v-bind:to="`/region/${departement.region_id}`"><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>                       
                            <h5 class="col-xl-11">                              
                                <small class="text-muted">Département</small><br>
                                {{departement.nom_departement}}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        Pourcentage de locaux raccordables (sur {{departement.logements + departement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                        <table class="table table-striped table-sm table-bordered" v-if="departement.ftthdepartements>[]">                                             
                            <thead class="table-secondary">                                      
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
                        
                        <p>
                        <small>Dans le département {{departement.nom_departement}}, il y a 
                        <strong>{{departement.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                        <strong>{{departement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                        soit un total de <strong>{{departement.logements + departement.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                        </small>
                        </p>
                        
                        <div class="row" v-if="departement.epci>[]">
                            <div class="col-xl-6 col-md-6">
                                <v-select label="nom_epci" @input='onSelectEpci' :options="epci" placeholder="Choisir un EPCI">
                                    <span slot="no-options">Aucun EPCI trouvé!</span>
                                </v-select><br> 
                                <div v-show="statepcis.length>0">
                                    <p>Plus forte progression sur les 3 derniers trimestres</p>                       
                                    <ul>      
                                        <li v-bind:key="statepci.id" v-for="statepci in statepcis">                               
                                            <strong><router-link class="" v-bind:to="`/epci/${statepci.epci.id}`">{{statepci.epci.nom_epci}}</router-link></strong> -> <strong>{{statepci.pourcentage_progression}}%</strong>
                                    </li> 
                                    </ul> 
                                </div>
                                <div v-show="ftthtopepcis.length>0">
                                    <p>Plus fort pourcentage de locaux raccordables au dernier trimestre.</p>                           
                                    <ul>     
                                        <li v-bind:key="ftthtopepci.id" v-for="ftthtopepci in ftthtopepcis">                               
                                            <strong><router-link class="" v-bind:to="`/epci/${ftthtopepci.epci.id}`">{{ftthtopepci.epci.nom_epci}}</router-link></strong> -> <strong>{{ftthtopepci.pourcentage}}</strong>
                                        </li> 
                                    </ul> 
                                </div>                                                        
                            </div>                            
                            <div class="col-xl-6 col-md-6 liste">                              
                                <v-select label="nom_commune" @input='onSelectCommune' :options="departement.communes" placeholder="Choisir une commune">
                                    <span slot="no-options">Aucune commune trouvée!</span>
                                </v-select><br>
                                <div v-show="statcommunes.length>0">
                                    <p>Plus forte progression sur les 3 derniers trimestres</p>                                    
                                    <ul>      
                                        <li v-bind:key="statcommune.id" v-for="statcommune in statcommunes" v-if="statcommune.pourcentage_progression>0">                               
                                            <strong><router-link class="" v-bind:to="`/commune/${statcommune.commune.id}`">{{statcommune.commune.nom_commune}}</router-link></strong> -> <strong>{{statcommune.pourcentage_progression}}%</strong>
                                        </li> 
                                    </ul>
                                </div>
                                <div v-show="ftthtopcommunes.length>0">       
                                    <p>Plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                                    <ul>     
                                        <li v-bind:key="ftthtopcommune.id" v-for="ftthtopcommune in ftthtopcommunes">                                            
                                            <strong><router-link class="" v-bind:to="`/commune/${ftthtopcommune.commune.id}`">{{ftthtopcommune.commune.nom_commune}}</router-link></strong> -> <strong>{{ftthtopcommune.pourcentage}}</strong>
                                        </li> 
                                    </ul> 
                                </div>                                                 
                            </div> 
                        </div>
                        <div class="row" v-else>                           
                            <div class="col-xl-6 col-md-6">
                                <div v-show="statcommunes.length>0">
                                    <p>Plus forte progression sur les 3 derniers trimestres</p>                                    
                                    <ul>      
                                        <li v-bind:key="statcommune.id" v-for="statcommune in statcommunes" v-if="statcommune.pourcentage_progression>0">                               
                                            <strong>{{statcommune.commune.nom_commune}}</strong> -> <strong>{{statcommune.pourcentage_progression}}%</strong>
                                        </li> 
                                    </ul>
                                </div>
                                <div v-show="ftthtopcommunes.length>0">       
                                    <p>Plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                                    <ul>     
                                        <li v-bind:key="ftthtopcommune.id" v-for="ftthtopcommune in ftthtopcommunes">                                            
                                            <strong>{{ftthtopcommune.commune.nom_commune}}</strong> -> <strong>{{ftthtopcommune.pourcentage}}</strong>
                                        </li> 
                                    </ul> 
                                </div>                                                 
                            </div> 
                             <div class="col-xl-6 col-md-6">                              
                                <v-select label="nom_commune" @input='onSelectCommune' :options="departement.communes" placeholder="Choisir une commune">
                                    <span slot="no-options">Aucune commune trouvée!</span>
                                </v-select>
                            </div>
                        </div>                  
                    </div>                    
                    <div class="card-footer">
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
                this.$router.push({ path: '/epci/' + epci.id })
            },
            onSelectCommune(commune) {
                this.$router.push({ path: '/commune/' + commune.id })
            },
        },
        name: 'Departement',
        data () {
            return {
                departement: {},
                statepcis: [],  
                statcommunes: [],
                ftthtopepcis:[],
                ftthtopcommunes: [],
                epci:[]
            }
        },        
        created () {
            this.isLoading = true;
            this.id = this.$route.params.id
            axios.get('api/departement/'+ this.id)
            .then(response => {
                this.departement = response.data
                       
            })
            .catch(Err => {
                // console.log(err)
            }),
            axios.get('api/epci/departement/'+ this.id) 
            .then(response =>{
                this.epci = response.data
            }),
            axios.get('api/stattopcommunes/departement/'+ this.id) 
            .then(response =>{
                this.statcommunes = response.data
            }),            
            axios.get('api/stattopepci/departement/'+ this.id) 
            .then(response =>{
                this.statepcis = response.data
            }),
            axios.get('api/ftthtopepci/departement/'+ this.id) 
            .then(response =>{
                this.ftthtopepcis = response.data
            }),
            axios.get('api/ftthtopcommunes/departement/'+ this.id) 
            .then(response =>{
                this.ftthtopcommunes = response.data
                this.isLoading = false;
            })
        }
    }
</script>

<style scoped>

</style>