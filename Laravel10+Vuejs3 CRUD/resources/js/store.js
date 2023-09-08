import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      alertMsg: {
        isMsgVal: null,
        isMessage: null,
      },
    };
  },
  mutations: {
    setPassedValues(state, { isMsgVal, isMessage }) {
      state.alertMsg.isMsgVal = isMsgVal;
      state.alertMsg.isMessage = isMessage;
    },
  },
});

export default store;
