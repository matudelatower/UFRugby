<template>
  <form-wizard shape="square" title="" subtitle="" color="#3498db"
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
      <precompetitivo-3 ref="step3" @show-next="mostrarSiguiente"
                        @on-validate="mergePartialModels" :final-model="finalModel"></precompetitivo-3>
    </tab-content>


    <template v-if="finalModel.categoria == 'infantil'">
      <tab-content title="4" icon="ti-settings" :before-change="()=>validateStep('step51')">
        <precompetitivo-5-1 ref="step51"
                            @on-validate="mergePartialModels">
        </precompetitivo-5-1>
      </tab-content>

      <tab-content title="5" icon="ti-settings">
        <precompetitivo-6 ref="step6" @on-validate="mergePartialModels"
                          :final-model="finalModel"
        ></precompetitivo-6>
      </tab-content>

      <tab-content title="6" icon="ti-settings" :before-change="()=>validateStep('step7')">
        <precompetitivo-7 ref="step7" @on-validate="mergePartialModels"></precompetitivo-7>
      </tab-content>
    </template>

    <template v-if="finalModel.categoria == 'referee'">
      <tab-content title="4" icon="ti-settings">
        <precompetitivo-6 ref="step6" @on-validate="mergePartialModels"
                          :final-model="finalModel"
        ></precompetitivo-6>
      </tab-content>
      <tab-content title="5" icon="ti-settings" :before-change="()=>validateStep('step7')">
        <precompetitivo-7 ref="step7" @on-validate="mergePartialModels"></precompetitivo-7>
      </tab-content>
    </template>

    <template v-if="finalModel.categoria == 'menor' || finalModel.categoria == 'mayor'">
      <tab-content title="4" icon="ti-settings">
        <precompetitivo-4 ref="step4" @on-validate="mergePartialModels"></precompetitivo-4>
      </tab-content>
      <tab-content title="5" icon="ti-settings" :before-change="()=>validateStep('step5')">
        <precompetitivo-5 :categoria="finalModel.categoria" ref="step5"
                          @on-validate="mergePartialModels"></precompetitivo-5>
      </tab-content>
      <tab-content title="6" icon="ti-settings">
        <precompetitivo-6 ref="step6" @on-validate="mergePartialModels"
                          :final-model="finalModel"
        ></precompetitivo-6>
      </tab-content>
      <tab-content title="7" icon="ti-settings" :before-change="()=>validateStep('step7')">
        <precompetitivo-7 ref="step7" @on-validate="mergePartialModels"></precompetitivo-7>
      </tab-content>
    </template>

    <BlockUI message="Procesando..." v-show="cargando"></BlockUI>

    <template slot="footer" slot-scope="props">
      <div class="wizard-footer-left">
        <wizard-button v-if="props.activeTabIndex > 0 && !props.isLastStep" @click.native="props.prevTab()"
                       :style="props.fillButtonStyle">Anterior
        </wizard-button>
      </div>
      <div class="wizard-footer-right" v-if="showNext">
        <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" class="wizard-footer-right"
                       :style="props.fillButtonStyle">Siguiente
        </wizard-button>

        <wizard-button v-else @click.native="props.nextTab()" class="wizard-footer-right finish-button"
                       :style="props.fillButtonStyle">{{ props.isLastStep ? 'Confirmar' : 'Siguiente' }}
        </wizard-button>

      </div>
    </template>
  </form-wizard>

</template>

<script>
export default {
  data: function () {
    return {
      finalModel: {},
      cargando: false,
      showNext: true
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
    mostrarSiguiente(event) {
      this.showNext = event

    },
    submit() {
      console.log(this.finalModel)

      this.cargando = true;

      let formData = new FormData();

      let data = this.buildFormData(formData, this.finalModel)

      axios.post(baseUrl + '/ajax-public/precompetitivo', data
          , {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(response => {
            console.log(response);
            this.cargando = false;
            location.href = response.data;

          })
          .catch(error => {
            this.cargando = false;
            console.log(error);
          });
    },
    buildFormData(formData, data, parentKey) {
      if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
        Object.keys(data).forEach(key => {
          this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
        });
      } else {
        const value = data == null ? '' : data;

        formData.append(parentKey, value);
      }
      return formData;
    }
  },
  mounted() {
    console.log('Component ready.')

  }
}
</script>
