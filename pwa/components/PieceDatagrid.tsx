import { useRecordContext } from 'react-admin';
import {fetchUtils, useGetList, useGetOne, WithListContext} from 'ra-core';
import {Chip, List, TextField} from "@mui/material";
import {Datagrid} from "ra-ui-materialui";
import {Stack} from "@mui/system";

const apiUrl = 'https://localhost'; // Remplacez par l'URL de votre API
const httpClient = fetchUtils.fetchJson;

const PieceDatagrid = props => {
  const record = useRecordContext();
  if (!record) return null;

  const url = `${apiUrl}/puzzles/${record.originId}/pieces`;
  const httpClient = (url: string, options = {}) => {
    if (!options.headers) {
      options.headers = new Headers({ Accept: 'application/ld+json' });
    }
    return fetchUtils.fetchJson(url, options);
  };

  const data = httpClient(url).then(({ json }) => ({
    pieces: json.pieces,
  }));
  return (
      <List
          data={data}
      >
        <Datagrid>
          <TextField source="id" />
        </Datagrid>
      </List>
  )
};

export default PieceDatagrid
