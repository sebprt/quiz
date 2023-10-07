<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231007121206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id UUID NOT NULL, name VARCHAR(255) NOT NULL, date DATE NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE map (id UUID NOT NULL, name VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN map.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE map_regions (map_id UUID NOT NULL, region_id UUID NOT NULL, PRIMARY KEY(map_id, region_id))');
        $this->addSql('CREATE INDEX IDX_8D4C81AF53C55F64 ON map_regions (map_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D4C81AF98260155 ON map_regions (region_id)');
        $this->addSql('COMMENT ON COLUMN map_regions.map_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN map_regions.region_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE math_problem (id UUID NOT NULL, text VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN math_problem.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE piece (id UUID NOT NULL, image_url VARCHAR(255) NOT NULL, location_x DOUBLE PRECISION NOT NULL, location_y DOUBLE PRECISION NOT NULL, is_missing BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN piece.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE piece_math_problems (piece_id UUID NOT NULL, math_problem_id UUID NOT NULL, PRIMARY KEY(piece_id, math_problem_id))');
        $this->addSql('CREATE INDEX IDX_1AA67229C40FCFA8 ON piece_math_problems (piece_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1AA672298432FAA1 ON piece_math_problems (math_problem_id)');
        $this->addSql('COMMENT ON COLUMN piece_math_problems.piece_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN piece_math_problems.math_problem_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE puzzle (id UUID NOT NULL, name VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN puzzle.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE puzzle_pieces (puzzle_id UUID NOT NULL, piece_id UUID NOT NULL, PRIMARY KEY(puzzle_id, piece_id))');
        $this->addSql('CREATE INDEX IDX_BA14324D9816812 ON puzzle_pieces (puzzle_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA14324C40FCFA8 ON puzzle_pieces (piece_id)');
        $this->addSql('COMMENT ON COLUMN puzzle_pieces.puzzle_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN puzzle_pieces.piece_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE question (id UUID NOT NULL, text VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN question.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE region (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, image_url VARCHAR(255) NOT NULL, is_unlocked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN region.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE region_questions (region_id UUID NOT NULL, region_question_id UUID NOT NULL, PRIMARY KEY(region_id, region_question_id))');
        $this->addSql('CREATE INDEX IDX_D91C00E198260155 ON region_questions (region_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D91C00E1C90BC365 ON region_questions (region_question_id)');
        $this->addSql('COMMENT ON COLUMN region_questions.region_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN region_questions.region_question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE region_question (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN region_question.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE sentence (id UUID NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN sentence.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE sentence_words (sentence_id UUID NOT NULL, word_id UUID NOT NULL, PRIMARY KEY(sentence_id, word_id))');
        $this->addSql('CREATE INDEX IDX_B5F31AD827289490 ON sentence_words (sentence_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B5F31AD8E357438D ON sentence_words (word_id)');
        $this->addSql('COMMENT ON COLUMN sentence_words.sentence_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN sentence_words.word_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE song (id UUID NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, audio_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN song.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE song_questions (song_id UUID NOT NULL, song_question_id UUID NOT NULL, PRIMARY KEY(song_id, song_question_id))');
        $this->addSql('CREATE INDEX IDX_F2704121A0BDB2F3 ON song_questions (song_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F270412132A4E41 ON song_questions (song_question_id)');
        $this->addSql('COMMENT ON COLUMN song_questions.song_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN song_questions.song_question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE song_question (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN song_question.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE word (id UUID NOT NULL, text VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN word.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE map_regions ADD CONSTRAINT FK_8D4C81AF53C55F64 FOREIGN KEY (map_id) REFERENCES map (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE map_regions ADD CONSTRAINT FK_8D4C81AF98260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece_math_problems ADD CONSTRAINT FK_1AA67229C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece_math_problems ADD CONSTRAINT FK_1AA672298432FAA1 FOREIGN KEY (math_problem_id) REFERENCES math_problem (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE puzzle_pieces ADD CONSTRAINT FK_BA14324D9816812 FOREIGN KEY (puzzle_id) REFERENCES puzzle (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE puzzle_pieces ADD CONSTRAINT FK_BA14324C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE region_questions ADD CONSTRAINT FK_D91C00E198260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE region_questions ADD CONSTRAINT FK_D91C00E1C90BC365 FOREIGN KEY (region_question_id) REFERENCES region_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE region_question ADD CONSTRAINT FK_C5304DBCBF396750 FOREIGN KEY (id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sentence_words ADD CONSTRAINT FK_B5F31AD827289490 FOREIGN KEY (sentence_id) REFERENCES sentence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sentence_words ADD CONSTRAINT FK_B5F31AD8E357438D FOREIGN KEY (word_id) REFERENCES word (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE song_questions ADD CONSTRAINT FK_F2704121A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE song_questions ADD CONSTRAINT FK_F270412132A4E41 FOREIGN KEY (song_question_id) REFERENCES song_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE song_question ADD CONSTRAINT FK_1D2B1F06BF396750 FOREIGN KEY (id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE map_regions DROP CONSTRAINT FK_8D4C81AF53C55F64');
        $this->addSql('ALTER TABLE map_regions DROP CONSTRAINT FK_8D4C81AF98260155');
        $this->addSql('ALTER TABLE piece_math_problems DROP CONSTRAINT FK_1AA67229C40FCFA8');
        $this->addSql('ALTER TABLE piece_math_problems DROP CONSTRAINT FK_1AA672298432FAA1');
        $this->addSql('ALTER TABLE puzzle_pieces DROP CONSTRAINT FK_BA14324D9816812');
        $this->addSql('ALTER TABLE puzzle_pieces DROP CONSTRAINT FK_BA14324C40FCFA8');
        $this->addSql('ALTER TABLE region_questions DROP CONSTRAINT FK_D91C00E198260155');
        $this->addSql('ALTER TABLE region_questions DROP CONSTRAINT FK_D91C00E1C90BC365');
        $this->addSql('ALTER TABLE region_question DROP CONSTRAINT FK_C5304DBCBF396750');
        $this->addSql('ALTER TABLE sentence_words DROP CONSTRAINT FK_B5F31AD827289490');
        $this->addSql('ALTER TABLE sentence_words DROP CONSTRAINT FK_B5F31AD8E357438D');
        $this->addSql('ALTER TABLE song_questions DROP CONSTRAINT FK_F2704121A0BDB2F3');
        $this->addSql('ALTER TABLE song_questions DROP CONSTRAINT FK_F270412132A4E41');
        $this->addSql('ALTER TABLE song_question DROP CONSTRAINT FK_1D2B1F06BF396750');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE map_regions');
        $this->addSql('DROP TABLE math_problem');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE piece_math_problems');
        $this->addSql('DROP TABLE puzzle');
        $this->addSql('DROP TABLE puzzle_pieces');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE region_questions');
        $this->addSql('DROP TABLE region_question');
        $this->addSql('DROP TABLE sentence');
        $this->addSql('DROP TABLE sentence_words');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE song_questions');
        $this->addSql('DROP TABLE song_question');
        $this->addSql('DROP TABLE word');
    }
}
