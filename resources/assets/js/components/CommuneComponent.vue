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
                            <router-link class="" v-bind:to="`/epci/${commune.epci_id}`" v-if="commune.epci>[]"><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>
                            <router-link v-bind:to="`/departement/${commune.departement_id}`" v-else><i class="fas fa-3x fa-chevron-left col-xl-1"></i></router-link>                       
                            <h5 class="col-xl-11">
                                <small class="text-muted">Commune</small><br>
                                {{commune.nom_commune}}
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        Pourcentage de locaux raccordables (sur {{commune.logements + commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux au total)
                        <table class="table table-striped table-sm table-bordered" v-if="commune.ftth_communes>[]">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Période</th>
                                    <th>Locaux raccordables</th>
                                    <th>Pourcentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-bind:key="ftthcommune.id" v-for="ftthcommune in orderBy(commune.ftth_communes, 'annee', 'trimestre', -1)">   
                                    <td>
                                        {{ftthcommune.trimestre}}<sup>{{ftthcommune.trimestre | pluralize('er','ème','ème','ème')}}</sup> trimestre {{ftthcommune.annee}} 
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

                        <p v-if="commune.etablissements > 1">
                            <small>
                                Dans la commune {{commune.nom_commune}}, il y a <strong>{{commune.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                                <strong>{{commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissements</strong>
                                soit un total de <strong>{{commune.logements + commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                            </small>
                        </p>
                        <p v-else-if="commune.etablissements > 0">
                            <small>
                                Dans la commune {{commune.nom_commune}}, il y a <strong>{{commune.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                                <strong>{{commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} établissement</strong>
                                soit un total de <strong>{{commune.logements + commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                            </small>
                        </p>
                        <p v-else>
                            <small>
                                Dans la commune {{commune.nom_commune}}, il y a <strong>{{commune.logements | currency('', 0, { thousandsSeparator: ' ' })}} logements</strong> et 
                                <strong> aucun établissement</strong>
                                soit un total de <strong>{{commune.logements + commune.etablissements | currency('', 0, { thousandsSeparator: ' ' })}} locaux.</strong>
                            </small>
                        </p>
                    

                        <div class="row" v-if="commune.arrondissements>[]">
                            <div class="col-xl-6 col-md-6">
                                <div v-show="commune.arrondissements>[]">
                                    <p>Plus forte progression sur les 3 derniers trimestres</p>
                                    <ul>      
                                        <li v-bind:key="stattoparrondissement.id" v-for="stattoparrondissement in stattoparrondissements">                               
                                            <strong><router-link class="" v-bind:to="`/arrondissement/${stattoparrondissement.arrondissement.id}`">{{stattoparrondissement.arrondissement.nom_arrondissement}}</router-link></strong>-> <strong>{{stattoparrondissement.pourcentage_progression}}%</strong>
                                        </li> 
                                    </ul>
                                </div>
                                <div v-show="commune.arrondissements>[]">
                                    <p>Plus fort pourcentage de locaux raccordables au dernier trimestre.</p>
                                    <ul>     
                                        <li v-bind:key="ftthtoparrondissement.id" v-for="ftthtoparrondissement in ftthtoparrondissements">                                    
                                            <strong><router-link class="" v-bind:to="`/arrondissement/${ftthtoparrondissement.arrondissement.id}`">{{ftthtoparrondissement.arrondissement.nom_arrondissement}}</router-link></strong> -> <strong>{{ftthtoparrondissement.pourcentage}}</strong>
                                        </li> 
                                    </ul> 
                                </div>  
                            </div>
                            <div class="col-xl-6 col-md-6 liste">
                                <v-select label="nom_arrondissement" @input='onSelectArrondissement' :options="commune.arrondissements" placeholder="Arrondissements">
                                    <span slot="no-options">Aucun arrondissement trouvé!</span>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
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
                this.$router.push({ path: '/arrondissement/' + arrondissement.id })
            }, 
        },
        name: 'Commune',
        data () {
            return {
                commune: [],
                ftthtoparrondissements: [],
                stattoparrondissements: []
            }
        },
        created () {
            this.isLoading = true;     
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/commune/'+ this.id)
            .then(response => {
                this.commune = response.data 
                this.isLoading = false
            })
            .catch(Err => {
                // console.log(err)
            }),
            axios.get('api/ftthtoparrondissements/commune/'+ this.id)
            .then(response => {
                this.ftthtoparrondissements = response.data 
            }),
            axios.get('api/stattoparrondissements/commune/'+ this.id) 
            .then(response => {
                this.stattoparrondissements = response.data 
            })
        },
    }
</script>

<style scoped>
</style>