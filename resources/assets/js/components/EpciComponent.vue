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
                            <router-link v-bind:to="`/departement/${epci.departement_id}`"><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>                       
                            <h5 class="col-xl-11">                              
                                <small class="text-muted">EPCI</small><br>
                                {{epci.nom_epci}}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        Pourcentage de locaux raccordables (sur {{epci.logements + epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                        <table class="table table-striped table-sm table-bordered" v-if="epci.ftthepci>[]">                                             
                            <thead class="table-secondary">                                      
                                <tr>
                                    <th>Période</th>                                                                              
                                    <th>Locaux raccordables</th>
                                    <th>Pourcentage</th>                 
                                </tr>
                            </thead>
                            <tbody>   
                                <tr v-bind:key="ftthepci.id" v-for="ftthepci in orderBy(epci.ftthepci, 'annee', 'trimestre', -1)"> 
                                    <td>     
                                        {{ftthepci.trimestre}}<sup>{{ftthepci.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{ftthepci.annee}} 
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
                        <p v-if="epci.etablissements > 1">
                            <small>
                                Dans l'EPCI {{epci.nom_epci}}, il y a <strong>{{epci.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                                <strong>{{epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                                soit un total de <strong>{{epci.logements + epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                            </small>
                        </p>
                        <p v-else-if="epci.etablissements > 0">
                            <small>
                                Dans l'EPCI {{epci.nom_epci}}, il y a <strong>{{epci.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                                <strong>{{epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissement</strong>
                                soit un total de <strong>{{epci.logements + epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                            </small>
                        </p>
                        <p v-else>
                            <small>
                                Dans l'EPCI {{epci.nom_epci}}, il y a <strong>{{epci.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                                <strong>aucun établissement</strong>
                                soit un total de <strong>{{epci.logements + epci.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                            </small>
                        </p>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div v-show="statcommunes.length>0">   
                                    <p>Plus forte progression sur les 3 derniers trimestres</p>
                                    <ul>      
                                        <li v-bind:key="statcommune.id" v-for="statcommune in statcommunes">                               
                                            <strong><router-link class="" v-bind:to="`/commune/${statcommune.commune.id}`">{{statcommune.commune.nom_commune}}</router-link></strong> -> <strong>{{statcommune.pourcentage_progression}}%</strong>
                                        </li> 
                                    </ul>
                                </div>
                                <div v-show="ftthtopcommunes.length>0">                                  
                                    <p>Plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                                    <ul>     
                                        <li v-bind:key="ftthtopcommune.id" v-for="ftthtopcommune in ftthtopcommunes" v-if="ftthtopcommune.categorie>0">                               
                                            <strong><router-link class="" v-bind:to="`/commune/${ftthtopcommune.commune.id}`">{{ftthtopcommune.commune.nom_commune}}</router-link></strong> -> <strong>{{ftthtopcommune.pourcentage}}</strong>
                                        </li> 
                                    </ul> 
                                </div> 
                            </div>
                            <div class="col-xl-6 col-md-6 liste">
                                <v-select label="nom_commune" @input='onSelectCommune' :options="epci.communes" placeholder="Choisir une commune">
                                     <span slot="no-options">Aucune commune trouvée!</span>
                                </v-select>
                            </div>
                        </div>
                   </div>
                    <div class="card-footer">                        
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
                epci: [],
                statcommunes: [],
                ftthtopcommunes: []
            }
        },
        created () {
            this.isLoading = true;     
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/epci/'+ this.id)
            .then(response => {
                this.epci = response.data    
            })
            .catch(Err => {
                // console.log(err)
            }),
            axios.get('api/stattopcommunes/epci/'+ this.id) 
            .then(response =>{
                this.statcommunes = response.data
            }),
            axios.get('api/ftthtopcommunes/epci/'+ this.id) 
            .then(response =>{
                this.ftthtopcommunes = response.data
                this.isLoading = false
            })
        },
    }
    
   
</script>

<style scoped>
  
</style>