<template>
    <div class="transaction-manager">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-6 form-inline">
                    <label class="mr-2">Show</label>
                    <div>
                        <select
                            class="form-control form-control-sm"
                            name=""
                            id=""
                            v-model="elementsPerPage"
                        >
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <span class="ml-2">entries</span>
                </div>
                <div class="col-6 form-inline justify-content-end">
                    <label>Search</label>
                    <input
                        type="text"
                        v-model="search"
                        placeholder="Search bill, customer..."
                        class="form-control ml-2"
                        v-on:keyup="currentPage = 1"
                    />
                </div>
            </div>
            <table
                class="table table-bordered"
                id=""
                width="100%"
                cellspacing="0"
            >
                <thead>
                    <tr>
                        <th
                            v-for="header in headerTable"
                            :key="header.key"
                            v-on:click="sortTable(header.col, header.sortable)"
                        >
                            {{ header.name }}
                            <span
                                class="arrow"
                                v-if="header.col == sortColumn"
                                v-bind:class="
                                    ascending ? 'arrow_up' : 'arrow_down'
                                "
                            ></span>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th v-for="header in headerTable" :key="header.key">
                            {{ header.name }}
                        </th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="trans in get_rows()" :key="trans.id">
                        <td>{{ trans.id }}</td>
                        <td>{{ trans.users.full_name }}</td>
                        <td>{{ trans.created_at | formatDate }}</td>
                        <td>
                            <div v-if="trans.seller_id">
                                {{ trans.managers.full_name }}
                            </div>
                            <div v-else>
                                <span
                                    v-if="trans.isAssign == false"
                                    class="text-danger"
                                    >Anonymous</span
                                >
                                <span v-else class="text-danger">
                                    <select
                                        v-model="seller"
                                        name="seller"
                                        class="select2"
                                        style="width: 100%;"
                                        @change="updateTransaction(trans)"
                                    >
                                        <option value="" disabled selected
                                            >Select your option</option
                                        >
                                        <optgroup
                                            label="Người bán được nhiều license nhất"
                                        >
                                            <option
                                                v-for="best in list_transaction.best"
                                                :key="best.seller_id"
                                                :value="{
                                                    seller_id: best.seller_id,
                                                    seller_name:
                                                        best.managers.full_name,
                                                    seller_email:
                                                        best.managers.email
                                                }"
                                                >{{
                                                    best.managers.full_name
                                                }}</option
                                            >
                                        </optgroup>
                                        <optgroup
                                            label="Người có thời gian làm việc lâu nhất"
                                        >
                                            <option
                                                v-for="long in list_transaction.long"
                                                :key="long.id"
                                                :value="{
                                                    seller_id: long.id,
                                                    seller_name: long.full_name,
                                                    seller_email: long.email
                                                }"
                                                >{{ long.full_name }}</option
                                            >
                                        </optgroup>
                                    </select>
                                </span>
                            </div>
                        </td>
                        <td>
                            <span v-if="trans.status === 1" class="text-success"
                                >Complete</span
                            >
                            <span
                                v-else-if="trans.status === null"
                                class="text-warning"
                                >Pending...</span
                            >
                        </td>
                        <td>$ {{ trans.total_money }}</td>
                        <td>
                            <span v-if="user_role == 1">
                                <button
                                    v-if="trans.isAssign === false"
                                    id="assign-seller"
                                    class="btn btn-primary"
                                    :disabled="trans.seller_id"
                                    @click="selectTransaction(trans)"
                                >
                                    Assign
                                </button>
                                <button
                                    v-if="trans.isAssign === true"
                                    id="assign-seller"
                                    class="btn btn-danger"
                                    :disabled="trans.seller_id"
                                    @click="selectTransaction(trans)"
                                >
                                    Cancel
                                </button>
                            </span>
                            <span v-else>
                                <button
                                    class="btn btn-primary"
                                    :disabled="trans.seller_id"
                                    @click="updateTransaction(trans)"
                                >
                                    Get
                                </button>
                            </span>

                            <a :href="'bill/detail/' + trans.id" class="btn"
                                ><i class="fas fa-info text-info"></i
                            ></a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination justify-content-end">
                <div
                    class="number"
                    :class="{ active: currentPage === 1 }"
                    @click="change_page(currentPage - 1)"
                >
                    Prev
                </div>
                <div
                    class="number"
                    v-for="i in num_pages()"
                    v-bind:class="[i == currentPage ? 'active' : '']"
                    v-on:click="change_page(i)"
                    :key="i"
                >
                    {{ i }}
                </div>
                <div
                    class="number"
                    :class="{ active: currentPage === num_pages() }"
                    @click="change_page(currentPage + 1)"
                >
                    Next
                </div>
            </div>
        </div>

        <!-- {{ list_transaction.trans[3] }} -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentPage: 1,
            elementsPerPage: 5,
            ascending: false,
            sortColumn: "",
            search: "",
            user_role: this.$userRole,
            seller: {
                seller_id: this.$userId,
                seller_name: this.$userName,
                seller_email: this.$userEmail
            },
            transaction: [],
            errors: [],
            headerTable: [
                { name: "Code bill", col: "id", sortable: true },
                { name: "Customer", col: "users.full_name", sortable: true },
                { name: "Date of purchase", col: "created_at", sortable: true },
                { name: "Seller", col: "managers.full_name", sortable: false },
                { name: "Process", col: "status", sortable: true },
                { name: "Total money", col: "total_money", sortable: true },
                { name: "Action", col: "action", sortable: false }
            ],
            list_transaction: []
            // selectTransaction: {}
        };
    },

    created() {
        this.getListTransaction();
    },

    methods: {
        getListTransaction: function() {
            axios
                .get("transaction")
                .then(response => {
                    (this.list_transaction = response.data),
                        this.list_transaction.trans.forEach(trans => {
                            Vue.set(trans, "isAssign", false);
                        });
                })
                .catch(error => {
                    this.errors = error.response.data.errors.name;
                });
        },
        selectTransaction: function(transaction) {
            // this.selectTransaction = { ...transaction }
            transaction.isAssign = !transaction.isAssign;
        },
        sendMail: function(transaction) {
            axios
                .post("admin_send_mail", {
                    customer_email: transaction.users.email,
                    customer_name: transaction.users.full_name,
                    seller_email: this.seller.seller_email,
                    seller_name: this.seller.seller_name,
                    bill_code: transaction.id
                    })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                });
        },
        updateTransaction: function(trans) {
            var transaction = []
            if (confirm("Are you sure?")) {
                axios
                    .get("transaction/" + trans.id)
                    .then(response => {
                        transaction = response.data;
                        var checkSeller = transaction.seller_id;
                        console.log(checkSeller);
                        if (checkSeller === null) {
                            axios
                                .put("transaction/" + trans.id, {
                                    seller: this.seller.seller_id
                                })
                                .then(response => {
                                    this.getListTransaction();
                                })
                                .catch(error => {
                                    this.errors =
                                        error.response.data.errors.name;
                                });
                            this.sendMail(trans);
                        } else {
                            alert("Can not Get. This bill has been assigned.");
                            this.getListTransaction();
                        }
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors.name;
                    });
            }
        },
        sortTable: function(col, sortable) {
            if (sortable) {
                if (this.sortColumn === col) {
                    this.ascending = !this.ascending;
                } else {
                    this.ascending = true;
                    this.sortColumn = col;
                }

                var ascending = this.ascending;

                if (col.indexOf(".") > -1) {
                    col = col.split(".");
                    var len = col.length;
                    this.filtedList.sort(function(a, b) {
                        var i = 0;
                        while (i < len) {
                            a = a[col[i]];
                            b = b[col[i]];
                            i++;
                        }
                        if (a < b) {
                            return ascending ? -1 : 1;
                        } else if (a > b) {
                            return ascending ? 1 : -1;
                        } else {
                            return 0;
                        }
                    });
                }

                this.filtedList.sort(function(a, b) {
                    if (a[col] > b[col]) {
                        return ascending ? 1 : -1;
                    } else if (a[col] < b[col]) {
                        return ascending ? -1 : 1;
                    }
                    return 0;
                });
            }
        },

        num_pages: function() {
            if (!this.filtedList) {
                return;
            }
            return Math.ceil(
                Object.keys(this.filtedList).length / this.elementsPerPage
            );
        },
        get_rows: function() {
            var elementsPerPage = parseInt(this.elementsPerPage);
            var start = (this.currentPage - 1) * elementsPerPage;
            var end = start + elementsPerPage;
            return (this.filtedList || "").slice(start, end);
        },
        change_page: function(page) {
            if (page < 1 || page > this.num_pages()) {
                return;
            }
            this.currentPage = page;
        }
    },

    computed: {
        filtedList() {
            if (!this.list_transaction.trans) {
                return;
            }
            return this.list_transaction.trans.filter(trans => {
                return (
                    String(trans.id)
                        .toLowerCase()
                        .includes(this.search.toLowerCase()) ||
                    String(trans.users.full_name)
                        .toLowerCase()
                        .includes(this.search.trim().toLowerCase())
                );
            });
        }
    }
};
</script>

<style lang="scss" scoped></style>
