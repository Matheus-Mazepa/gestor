<script>
import SortIcon from '../../commons/SortIcon';
export default {
  template: '#data-list',

  mixins: [
  ],

  props: {
    dataSource: {
      type: String,
    },

    urlCreate: {
      type: String,
      default() {
        return null;
      },
    },

    urlActiveCompanies: {
      type: String,
    },

    urlDisabledCompanies: {
      type: String,
    },

    labelCreate: {
      type: String,
      default() {
        return 'Cadastrar novo';
      },
    },

    deleteTitle: {
      type: String,
      default() {
        return 'Tem certeza que deseja apagar este registro?';
      },
    },

    deleteMessage: {
      type: String,
      default() {
        return 'Tem certeza que deseja apagar este registro?';
      },
    },
  },

  watch: {
    query: _.debounce(function (text) {
      this.currentPage = 1;
    }, 300),

    fetch_url: _.debounce(function (text) {
      this.fetchData();
    }, 200),
  },

  computed: {
     queryFilters() {
      let query_filters = '';
      for (var filterName in this.filters) {
        if (this.filters.hasOwnProperty(filterName)) {
          query_filters += '&' + filterName + '=' + this.filters[filterName];
        }
      }
      return query_filters;
    },

    fetch_url() {
      let query_params = '';
      query_params = '?query=' + this.query;
      query_params += '&field=' + this.field;
      query_params += '&order=' + this.sortIcon.order;

      _.forEach(this.filterType, function (value, key) {
        if (value !== 'undefined' && value !== null && typeof value === 'object') {
          query_params += '&' + key + '=' + value.id;
        } else if (value !== 'undefined' && value !== null) {
          query_params += '&' + key + '=' + value;
        }
      });

      if (this.currentPage != 1) {
        query_params += '&page=' + this.currentPage;
      }

      query_params += this.queryFilters;

      const url = this.dataSource + query_params;
      return url;
    },

    no_results() {
      return typeof this.items == 'undefined' || this.items.length == 0;
    },

    enabledNextPageButton() {
      return this.currentPage < this.totalPages;
    },

    enabledPrevPageButton() {
      return this.currentPage > 1;
    },

    shouldShowPagination() {
      return this.totalPages > 1;
    },
  },

  data: function () {
    return {
      items: [],
      filters: {
        perPage: 30,
      },

      query: '',
      field: '',
      filterType: {},
      isLoading: true,
      sortIcon: new SortIcon,
      totalPages: 1,
      currentPage: 1,
      itemsPerPage: 15,
      paginationButtons: [],

      count: {
        activeCompanies: 0,
        disabledCompanies: 0,
        totalCompanies: 0
      },
    }
  },

  mounted() {
    this.sortIcon.setArrow();
    this.listenFilters();
    this.fetchData().then(() => {
      if (!!window.__FILTER__) {
        this.filterType = window.__FILTER__;
      }
    });

    this.listenLoadingEvents();
  },

  methods: {
    getRef(ref) {
      return this.$refs[ref];
    },

    orderBy(field, event) {
      this.field = field;
      this.sortIcon.change(event);
    },

    setPagination(fetched_data) {
      if (typeof fetched_data !== 'undefined') {
        this.totalPages = fetched_data.last_page;
        this.currentPage = fetched_data.current_page;
        this.itemsPerPage = fetched_data.per_page;
      }
    },

    async fetchData() {
      this.$root.$emit('start-loading');
      const response = await axios.get(this.fetch_url);

      this.items = response.data.data;
      this.setPagination(response.data.meta);
      this.definePaginationButtons();
      this.updateTotal(response.data);
      this.updateActiveCompanies();
      this.updateDisabledCompanies();
      this.$root.$emit('stop-loading');
      this.$nextTick().then(function () {
        $('[data-toggle="popover"]').popover();
      });
    },

    listenFilters() {
      this.$on('setFilter', (payload) => {
        this.setFilter(payload.urlKey, payload.value);
      });
    },

    setFilter(name, value) {
      if (value) {
        this.$set(this.filters, name, value)
      } else {
        delete this.filters[name];
        this.filters = _.assign({}, this.filters);
      }
    },

    fetchPrevPage() {
      if (this.enabledPrevPageButton) {
        this.currentPage = this.currentPage - 1;
        this.fetchData();
      }
    },

    fetchNextPage() {
      if (this.enabledNextPageButton) {
        this.currentPage = this.currentPage + 1;
        this.fetchData();
      }
    },

    definePaginationButtons() {
      const totalPages = this.totalPages;
      let startPage = this.currentPage - 2;
      let endPage = this.currentPage + 2;
      let buttons = [];

      if (startPage <= 0) {
        endPage -= (startPage - 1);
        startPage = 1;
      }

      if (endPage > totalPages)
      endPage = totalPages;

      if (startPage > 1) {
        buttons.push({disabled: false, page: 1, text: '1'});
        buttons.push({disabled: true, page: 0, text: '...'});
      }

      for (let i = startPage; i <= endPage; i++) {
        const active = (i == this.currentPage);
        buttons.push({disabled: false, page: i, text: i, active: active});
      }

      if (endPage < totalPages) {
        buttons.push({disabled: true, page: 0, text: '...'});
        buttons.push({disabled: false, page: totalPages, text: totalPages});
      }

      this.paginationButtons = buttons;
    },

    changePage(page) {
      this.currentPage = page;
      this.fetchData();
    },

    handleDelete(link) {
      axios.delete(link).then((response) => {
        const status = response.data;
        if (status.type) {
          this.$snotify[status.type](status.message);
          this.fetchData();
        } else {
          this.$snotify.error('Action undefined');
        }
      });
    },

    handlePost(link) {
      axios.post(link).then((response) => {
        const status = response.data;
        if (status.type) {
          this.$snotify[status.type](status.message);
          this.fetchData();
        } else {
          this.$snotify.error('Action undefined');
        }
      });
    },

    activate(link) {
      axios.post(link).then((response) => {
        const status = response.data;
        if (status.type) {
          this.$snotify[status.type](status.message);
          $('.tooltip').remove();
          this.fetchData();
        } else {
          this.$snotify.error('Action undefined');
        }
      });
    },

    deactivate(link) {
      axios.post(link).then((response) => {
        const status = response.data;
        if (status.type) {
          this.$snotify[status.type](status.message);
          $('.tooltip').remove();
          this.fetchData();
        } else {
          this.$snotify.error('Action undefined');
        }
      });
    },

    resendEmail(link) {
      axios.get(link).then((response) => {
        const status = response.data;
        if (status.type) {
          this.$snotify[status.type](status.message);
          $('.tooltip').remove();
          this.fetchData();
        } else {
          this.$snotify.error('Action undefined');
        }
      });
    },

    confirmDelete(link, title = undefined, message = undefined) {
      if (title == undefined) {
        title = this.deleteTitle;
      }

      if (message == undefined) {
        message = this.deleteMessage;
      }

      this.$snotify.confirm(message, title, {
        timeout: 5000,
        showProgressBar: false,
        closeOnClick: true,
        pauseOnHover: false,
        buttons: [
          {
            text: 'Sim',
            action: (toast) => {
              this.handleDelete(link);
              this.$snotify.remove(toast.id);
            },
            bold: false
          },
          {text: 'Não'},
        ]
      });
    },

    confirmAndPost(link, title, message) {
      this.$snotify.confirm(message, title, {
        timeout: 5000,
        showProgressBar: false,
        closeOnClick: true,
        pauseOnHover: false,
        buttons: [
          {text: 'Sim', action: () => this.handlePost(link), bold: false},
          {text: 'Não'},
        ]
      });
    },

    confirmActivateDeactivate(link, action, message = undefined) {
      let title = 'Ativar';
      if (message == undefined) {
        if (action == 'activate') {
          message = 'Tem certeza que deseja ativar esta empresa?';
        } else {
          title = 'Desativar';
          message = 'Tem certeza que deseja desativar esta empresa?';
        }
      }

      this.$snotify.confirm(message, title, {
        timeout: 5000,
        showProgressBar: false,
        closeOnClick: true,
        pauseOnHover: false,
        buttons: [
          {text: 'Sim', action: () => this.activate(link), bold: false},
          {text: 'Não'},
        ]
      });
    },

    confirmApproveVip(link) {
      let title = 'Aprovar';
      let message = 'Tem certeza que deseja aprovar esse cliente como VIP?';

      this.$snotify.confirm(message, title, {
        timeout: 1000,
        showProgressBar: false,
        closeOnClick: true,
        pauseOnHover: false,
        buttons: [
          {text: 'Sim', action: () => this.handlePost(link), bold: false},
          {text: 'Não'},
        ]
      });
    },

    confirmResendEmail(link, message = undefined) {
      if (message === undefined) {
        message = 'Tem certeza que deseja reenviar este e-mail?';
      }

      this.$snotify.confirm(message, 'Reenviar e-mail?', {
        timeout: 5000,
        showProgressBar: false,
        closeOnClick: true,
        pauseOnHover: false,
        buttons: [
          {text: 'Sim', action: () => this.resendEmail(link), bold: false},
          {text: 'Não'},
        ]
      });
    },

    updateTotal(data) {
      this.count.totalCompanies = data.meta.total;
    },

    async updateActiveCompanies() {
      if (this.urlActiveCompanies != undefined) {
        const numberActiveCompanies = await axios.get(this.urlActiveCompanies);
        this.count.activeCompanies = numberActiveCompanies.data;
      }
    },

    async updateDisabledCompanies() {
      if (this.urlDisabledCompanies != undefined) {
        const numberDisabledCompanies = await axios.get(this.urlDisabledCompanies);
        this.count.disabledCompanies = numberDisabledCompanies.data;
      }
    },

    listenLoadingEvents() {
      this.$root.$on('start-loading', () => {
        this.isLoading = true;
      });

      this.$root.$on('stop-loading', () => {
        this.isLoading = false;
      });
    },
  },
}
</script>

<style>
</style>
