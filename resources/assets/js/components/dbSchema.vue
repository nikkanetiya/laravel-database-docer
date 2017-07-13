<template>
    <div>
        <table v-for="table in filterTables" v-if="filterTables" class="table table-bordered table-list">
            <caption>{{ table.name }}</caption>
            <thead v-if=" ! isOnlyForeignKey">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Allow Null</th>
                    <th>Key</th>
                    <th>Default/Attribute</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="column in table.columns" v-if=" ! isOnlyForeignKey && table.columns">
                    <td>{{ column.name }}</td>
                    <td>{{ column.type }} <span v-if="column.length">({{ column.length }})</span></td>
                    <td>{{ column.notnull ? '' : 'Nullable' }}</td>
                    <td>{{ column.isPrimaryKey ? 'PK' : '' }} {{ column.isForeignKey ? ' FK' : '' }}</td>
                    <td>{{ column.default ? column.default : '' }} {{ column.autoincrement ? 'Auto Increment' : '' }}</td>
                </tr>
                <tr v-if="showForeignKey && table.foreignKeys">
                    <td colspan="5">
                        <table width="100%" class="table table-bordered foreign-keys">
                            <caption>Foreign Keys</caption>
                            <thead>
                                <tr>
                                    <th>Constraint Name</th>
                                    <th>Local Table</th>
                                    <th>Local Column</th>
                                    <th>Foreign Table</th>
                                    <th>Foreign Column</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="foreignKey in table.foreignKeys">
                                    <td>{{ foreignKey.constraint_name }}</td>
                                    <td>{{ foreignKey.local_table }}</td>
                                    <td>{{ foreignKey.local_columns | implode }}</td>
                                    <td>{{ foreignKey.foreign_table }}</td>
                                    <td>{{ foreignKey.foreign_columns | implode }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dbTables', 'dataOption'],
        computed: {
            filterTables() {
                return this.dbTables.filter((table) => {
                    return this.dataOption != 3 || table.foreignKeys;
                });
            },
            isOnlyForeignKey() {
                return this.dataOption == 3;
            },
            showForeignKey() {
                return this.dataOption != 2;
            }
        }
    }
</script>
