<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Stats arcep du département : {{departement.nom_departement}}</div>

                    <div class="card-body">
                        <table class="table table-sm table-hover">                 
                            <thead class="thead-dark">           
                                <tr>
                                    <th>Nom du département</th>              
                                    <th>Numéro de département</th>
                                    <th>Numéro de région</th>
                                    <th>Logements</th>
                                    <th>Établissements</th>
                                </tr>
                            </thead>
                            <tbody>   
                                <tr>                             
                                    <td>{{departement.nom_departement}}</td>
                                    <td>{{departement.code_departement}}</td>
                                    <td>{{departement.code_region}}</td>
                                    <td>{{departement.logements}}</td>
                                    <td>{{departement.etablissements}}</td>
                                </tr>          
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: 'Departement',
        data () {
            return {
                departement: {}
            }
        },
        created () {
            this.id = this.$route.params.id
            axios.get('http://localhost:8000/api/departements/'+ this.id)
            .then(response => {
                console.log(response)
                this.departement = response.data
                // this.comp = JSON.parse(response.data)
            })
            .catch(Err => {
                // console.log(err)
            })
        }
    }
</script>
