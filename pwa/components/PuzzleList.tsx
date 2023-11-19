import {
  HydraAdmin,
  ResourceGuesser,
  ListGuesser,
  FieldGuesser
} from "@api-platform/admin";

const PuzzleList = props => (
  <ListGuesser {...props}>
    <FieldGuesser source="name" />
    <FieldGuesser source="imageUrl" />
  </ListGuesser>
);

export default PuzzleList
