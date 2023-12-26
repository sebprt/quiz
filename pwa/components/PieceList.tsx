import {useEffect, useState} from 'react';
import {useGetRecordId} from "ra-core";
import { DataGrid, GridColDef, GridValueGetterParams } from '@mui/x-data-grid'
import {
  TabbedForm,
  List,
  Datagrid,
  TextField,
  DateField,
  TextInput,
  ReferenceManyField,
  NumberInput,
  DateInput,
  BooleanInput,
  EditButton
} from 'react-admin';

const PieceList = () => {
  const recordId = useGetRecordId();
  const [data, setData] = useState();
  const [error, setError] = useState<string | undefined>();
  useEffect(() => {
    (async () => {
      try {
        console.log(recordId)

        const response = await fetch(`${recordId}/pieces`);
        console.log(response)
        if (response?.status === 200) {
          response.json().then(data => setData(data["pieces"] ?? []))
        }
      } catch (error) {
        console.error(error);
        // @ts-ignore
        setError(error.message);

        return;
      }
    })();
  }, []);

  const columns = [
    { field: 'id', headerName: 'Id'},
    { field: 'firstName', headerName: 'First name'},
    { field: 'lastName', headerName: 'Last name'},
    {
      field: 'age',
      headerName: 'Age',
      type: 'number',
    },
  ];

  console.log(data)
  return (
      <>
        <DataGrid
            autoHeight
            disableColumnMenu
            rows={data ?? []}
            columns={columns}
            initialState={{
              pagination: {
                paginationModel: { page: 0, pageSize: 5 },
              },
              sorting: {
                sortModel: [{ field: 'id', sort: 'desc' }],
              },
            }}
            pageSizeOptions={[5, 10]}
            checkboxSelection
        />
        <List>
          <Datagrid>
            <TextField source="id" />
            <TextField source="title" />
            <EditButton />
          </Datagrid>
        </List>
      </>
  )
};

export default PieceList
