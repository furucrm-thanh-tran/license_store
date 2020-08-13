<template>
    <div class="transaction-manager">
        <table class="table table-bordered" id="" width="100%" cellspacing="0">
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
                            v-bind:class="ascending ? 'arrow_up' : 'arrow_down'"
                        ></span>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Code bill</th>
                    <th>Customer ID</th>
                    <th>Date of purchase</th>
                    <th>Seller</th>
                    <th>Process</th>
                    <th>Total money</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                <tr
                    v-for="(trans, index) in list_transaction.trans"
                    :key="trans.id"
                >
                    <td>{{ trans.id }}</td>
                    <td>{{ trans.users.full_name }}</td>
                    <td>{{ trans.created_at }}</td>
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
                                    @change="updateTransaction(index)"
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
                                                    best.managers.full_name
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
                                                seller_name: long.full_name
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
                                @click="updateTransaction(index)"
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
        <!-- {{ list_transaction.trans[3] }} -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            ascending: false,
            sortColumn: "",
            user_role: this.$userRole,
            seller: {
                seller_id: this.$userId,
                seller_name: this.$userName
            },
            errors: [],
            headerTable: [
                { name: "Code bill", col: "id", sortable: true },
                { name: "Customer", col: "users.full_name", sortable: true },
                { name: "Date of purchase", col: "created_at", sortable: true },
                { name: "Seller", col: "managers.full_name", sortable: false },
                { name: "Process", col: "status", sortable: true },
                { name: "Total money", col: "total_money", sortable: true },
                { name: "Action", col: "", sortable: false }
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
        updateTransaction: function(index) {
            if (confirm("Are you sure?")) {
                axios
                    .put(
                        "transaction/" + this.list_transaction.trans[index].id,
                        {
                            seller: this.seller.seller_id
                        }
                    )
                    .then(response => {
                        (this.list_transaction.trans[
                            index
                        ].seller_id = this.seller.seller_id),
                            (this.list_transaction.trans[
                                index
                            ].managers = Object.assign(
                                {},
                                this.list_transaction.trans[index].managers,
                                { full_name: this.seller.seller_name }
                            ));
                        this.list_transaction.trans[index].isAssign = false;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors.name;
                    });
            }
        },
        sortTable: function sortTable(col, sortable) {
            if (sortable) {
                if (this.sortColumn === col) {
                    this.ascending = !this.ascending;
                } else {
                    this.ascending = true;
                    this.sortColumn = col;
                }

                var ascending = this.ascending;

                if (col.indexOf(".") > -1) {
                    // alert("hello found inside your_string");
                    col = col.split(".");
                    var len = col.length;
                    // alert("hello found inside your_string" + col[0]);
                    // this.list_transaction.trans = Object.values(this.list_transaction.trans).sort((a, b) => a.users.full_name.localeCompare(b.users.full_name));
                    this.list_transaction.trans.sort(function(a, b) {
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

                this.list_transaction.trans.sort(function(a, b) {
                    if (a[col] > b[col]) {
                        return ascending ? 1 : -1;
                    } else if (a[col] < b[col]) {
                        return ascending ? -1 : 1;
                    }
                    return 0;
                });
            }
        }
    },
    computed: {
        columns: function columns() {
            if (this.list_transaction.trans.length == 0) {
                return [];
            }
            return Object.keys(this.list_transaction.trans[0]);
        }
    }
};
</script>

<style lang="scss" scoped></style>
