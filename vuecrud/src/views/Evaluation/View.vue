<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Generate Member Evaluation</h4>
            </div>
            <div class="card-body">

                <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
                    <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="indexEval">
                        {{ error[0]  }}
                    </li>
                </ul>
                <div class="mb-3">
                    <label for="">Project</label>
                    <input type="text" v-model="model.eval.project" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Evaluation Period</label>
                    <input type="text" v-model="model.eval.evalPeriod" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Work Location</label>
                    <input type="text" v-model="model.eval.workLoc" class="form-control">
                </div>
                <div class="mb3">
                    <button type="button" @click="saveEval" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios'

export default {
    name: 'evalCreate',
    data(){
        return {
            errorList: '',
            model: {
                eval: {
                    project: '',
                    evalPeriod: '',
                    workLoc: ''
                }
            }
        }
    },
    methods: {
        saveEval(){

            var mythis = this;
            axios.post('http://127.0.0.1:8000/api/evals', this.model.eval)
                .then(res=>{
                    console.log(res.data)
                    alert(res.data.message)

                    this.model.eval = {
                        project: '',
                        evalPeriod: '',
                        workLoc: ''
                    }
                })
                .catch(function (error) {
                    if (error.response) {
                        
                        if(error.response.status == 422){
                            mythis.errorList = error.response.data.errors;
                        }
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                })
        }
    }
}

</script>