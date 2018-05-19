<template>
    <form-wizard shape="square" title="" subtitle="" color="#3498db"
                 next-button-text="Siguiente"
                 back-button-text="Anterior"
                 finish-button-text="Confirmar"
                 @on-complete="submit"
    >
        <tab-content title="1" icon="ti-user">
            <precompetitivo-1 ref="step1" @on-validate="mergePartialModels">
                <template slot="textoPresentacion">
                    <slot name="textoPresentacion">
                    </slot>
                </template>
            </precompetitivo-1>
        </tab-content>
        <tab-content title="2" icon="ti-user" :before-change="()=>validateStep('step2')">
            <precompetitivo-2 ref="step2" @on-validate="mergePartialModels"></precompetitivo-2>
        </tab-content>
        <tab-content title="3" icon="ti-settings" :before-change="()=>validateStep('step3')">
            <precompetitivo-3 ref="step3"
                              @on-validate="mergePartialModels"></precompetitivo-3>
        </tab-content>
        <tab-content title="4" icon="ti-settings">
            <precompetitivo-4 ref="step4" @on-validate="mergePartialModels"></precompetitivo-4>
        </tab-content>
        <tab-content title="5" icon="ti-settings" :before-change="()=>validateStep('step5')">
            <precompetitivo-5 :categoria="finalModel.categoria" ref="step5"
                              @on-validate="mergePartialModels"></precompetitivo-5>
        </tab-content>

        <template v-if="finalModel.categoria == 'infantil'">
            <tab-content title="6" icon="ti-settings" :before-change="()=>validateStep('step51')">
                <precompetitivo-5-1 ref="step51"
                                    @on-validate="mergePartialModels">
                </precompetitivo-5-1>
            </tab-content>

            <tab-content title="7" icon="ti-settings">
                <precompetitivo-6 ref="step6" @on-validate="mergePartialModels"
                                  :final-model="finalModel"
                ></precompetitivo-6>
            </tab-content>

            <tab-content title="8" icon="ti-settings" :before-change="()=>validateStep('step7')">
                <precompetitivo-7 ref="step7" @on-validate="mergePartialModels"></precompetitivo-7>
            </tab-content>
        </template>

        <template v-else>
            <tab-content title="6" icon="ti-settings">
                <precompetitivo-6 ref="step6" @on-validate="mergePartialModels"
                                  :final-model="finalModel"
                ></precompetitivo-6>
            </tab-content>
            <tab-content title="7" icon="ti-settings" :before-change="()=>validateStep('step7')">
                <precompetitivo-7 ref="step7" @on-validate="mergePartialModels"></precompetitivo-7>
                <BlockUI message="Procesando..." v-show="cargando"></BlockUI>
            </tab-content>
        </template>
        <!--<tab-content title="Last step" icon="ti-check">-->
        <!--Here is your final model:-->
        <!--<pre>{{ finalModel }}</pre>-->
        <!--</tab-content>-->
    </form-wizard>

</template>

<script>
    export default {
        data: function () {
            return {
                finalModel: {},
                cargando: false
            }
        },
        methods: {
            validateStep(name) {
                var refToValidate = this.$refs[name];
                return refToValidate.validate();
            },
            mergePartialModels(model, isValid) {
                if (isValid) {
                    // merging each step model into the final model
                    this.finalModel = Object.assign({}, this.finalModel, model)
                }
            },
            submit() {
                console.log(this.finalModel)

                this.cargando = true;

                axios.post(baseUrl + '/ajax-public/precompetitivo', {
                    data: this.finalModel
                })
                    .then(response => {
                        console.log(response);
                        this.cargando = false;
                        location.href = response.data;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        mounted() {
            console.log('Component ready.')

        }
    }
</script>