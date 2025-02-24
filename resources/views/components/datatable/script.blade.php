@section('script')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        const columns = [{
            data: 'DT_RowIndex',
            name: '#',
            searchable: false
        }];
        @foreach ($tableFields as $column)
            columns.push({
                data: '{{ $column->field_name }}',
                name: '{{ $column->field_name }}',
            });
        @endforeach

        columns.push({
            data: 'action',
            name: 'action',
        });
        $(function() {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: "{{ datatableLanguage() }}"

                },
                ajax: "{{ route($route) }}",
                columns: columns
            });

        });
    </script>
@endsection
