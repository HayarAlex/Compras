@verbatim
    <template id="tmpl-tipo">
        <tr>
            <template v-if="!editing">
                <td class="text-center">{{ item.namepsh }}</td>
                <td class="text-center">{{ item.detpsh }}</td>
                <td class="text-center">{{ item.canatsh }}</td>
                <td class="text-center">{{ item.presunish }}</td>
                <td class="text-center">{{ item.fenvp }}</td>
                <td class="text-center">{{ item.fresp }}</td>
                <td class="text-center">{{ item.docs }}</td>
                <td class="text-center">
                    <a href="#" class="updateinfo" onclick="showModalList(1)" :data-nom="item.iddetsh" :data-des="item.detpsh">
                        <i class="fa fa-list"></i>
                    </a>
                </td>
            </template>
        </tr>
    </template>
@endverbatim
