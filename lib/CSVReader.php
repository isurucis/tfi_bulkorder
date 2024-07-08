<?php

/**
 * CSV Library
 *
 * A library for reading, creating and editing CSV files.
 *
 * @author        Jelmer Schreuder, MijnPraktijk Webservices
 * @copyright    Copyright (c) 2010, Jelmer Schreuder
 * @license        MIT
 * @link        http://bitbucket.org/mijnpraktijk/csv-library
 * @version        0.8 (beta)
 *
 * LICENSE
 * ----------------
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class CsvReader
{
    /**
     * Keeps the filename to be created, read or edited.
     * @var string
     */
    protected $filename;

    /**
     * Keeps the handle during file operations
     * @var resource
     */
    protected $handle;

    /**
     * File contents as an array, first dimension is the line, second is the column
     * @var array
     */
    protected $contents = array();

    /**
     * Charcter that's used to seperate cells
     * @var char
     */
    protected $delimiter;

    /**
     * Character that's used to enclose strings
     * @var char
     */
    protected $enclosure;

    /**
     * Whether there are field names in the first row
     * @var bool
     */
    protected $field_names_first;

    /**
     * An enumirated array of the field names
     * @var array
     */
    public $field_names = array();

    /**
     * Constructor
     * Sets the filename and config items
     * @param string $filename
     * @param bool $field_names_first
     * @param char $delimiter
     * @param char $enclosure
     */
    public function __construct($filename, $field_names_first = true, $delimiter = ',', $enclosure = '"')
    {
        $this->set_filename($filename);

        $this->field_names_first = $field_names_first;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * Get
     * Static method to create new CSV instance
     * @param string $filename
     * @param bool $field_names_first
     * @param char $delimiter
     * @param char $enclosure
     * @return Csv
     */
    public static function get($filename, $field_names_first = true, $delimiter = ',', $enclosure = '"')
    {
        $csv = new CsvReader($filename, $field_names_first, $delimiter, $enclosure);
        $csv->load_file();
        return $csv;
    }

    /**
     * Get Handle
     * Retrieves the handle from $this->handle, throws an error when none was set.
     * @return resource
     */
    public function get_handle()
    {
        if (!is_resource($this->handle)) {
            throw new Exception('CSV Library: No resource to return.');
        }

        return $this->handle;
    }

    /**
     * Set handle
     * Sets the $this->handle variable, but only to a resource or to NULL.
     * @param resource $handle
     * @return void
     */
    public function set_handle($handle)
    {
        if (!is_resource($handle) && !is_null($handle)) {
            throw new Exception('CSV Library: Handle can only be set to a resource or NULL.');
        }

        $this->handle = $handle;
    }

    /**
     * Open handle
     * fopen() wrapper
     * @param resource $csv
     * @param string $operation
     * @return void
     */
    public static function open_handle($csv, $operation = 'r')
    {
        $handle = fopen($csv->get_filename(), $operation);
        if ($handle === false) {
            throw new Exception('CSV Library: Failed to open file handle.');
        }

        $csv->set_handle($handle);
    }

    /**
     * Close Handle
     * fclose() wrapper
     * @param resource $csv
     * @return void
     */
    public static function close_handle($csv)
    {
        $handle = $csv->get_handle();

        if (@fclose($handle) === false) {
            throw new Exception('CSV Library: Failed to close file handle.');
        }

        $csv->set_handle(null);
    }

    /**
     * Get filename
     * Returns the filename in $this->filename
     * @return string
     */
    public function get_filename()
    {
        return $this->filename;
    }

    /**
     * Set Filename
     * Sets the filename, can be given without ".csv".
     * @param string $filename
     * @param string $where directory to be used as base (sys = system path, app = application path, or index.php path)
     * @return Csv
     */
    public function set_filename($filename, $where = '')
    {
        if (substr($where, 0, 3) == 'sys') {
            $filename = SYSDIR . $filename;
        } elseif (substr($where, 0, 3) == 'app') {
            $filename = APPPATH . $filename;
        } elseif (!file_exists($filename)) {
            $filename = FCPATH . $filename;
        }

        if (!is_file($filename) && preg_match('/\.csv$/i', $filename) == 0) {
            $filename .= '.csv';
        }

        $this->filename = $filename;

        return $this;
    }

    /**
     * Load file
     * Loads the file set in set_filename() into $this->contents as an array
     * @return Csv
     */
    public function load_file()
    {
        if (empty($this->filename) || !is_file($this->filename)) {
            return $this;
        }

        CsvReader::open_handle($this);

        $this->new_contents();

        if ($this->field_names_first) {
            $this->field_names = fgetcsv($this->handle, null, $this->delimiter, $this->enclosure);
        }

        while (($row = fgetcsv($this->handle, null, $this->delimiter, $this->enclosure)) !== false) {
            $this->contents[] = $row;
        }

        CsvReader::close_handle($this);

        return $this;
    }

    /**
     * Save file
     * Saves what is in the contents array. When $force_new is enabled it will try to number
     * the CSV in order to create a new file instead of overwriting the old one.
     * @param bool $force_new
     */
    public function save_file($force_new = false)
    {
        while ($force_new === true && is_file($this->filename)) {
            $this->filename = preg_match('/_([0-9]{1,})?\.([a-z0-9]{1,4})$/i', $this->filename, $matches);
            $number = (int) $matches[1] + 1;
            $ext = $matches[2];
            $this->filename = preg_replace('/_' . str_replace('.', '\.', $matches[0]) . '/', '_' . $number . $ext, $this->filename);
        }

        if ($this->field_names_first) {
            array_unshift($this->contents, $this->field_names);
        }

        Csv::open_handle($this, 'w');

        foreach ($this->contents as $line) {
            fputcsv($this->handle, $line, $this->delimiter, $this->enclosure);
        }

        Csv::close_handle($this);
    }

    /**
     * New content
     * Starts empty or replaces the current content with the given array
     * @param array $contents
     * @return Csv
     */
    public function new_contents($contents = array(), $field_names = array())
    {
        if (!is_array($contents)) {
            throw new Exception('CSV Library: Contents must be in the form of an array.');
        }

        $this->contents = $contents;
        $this->set_field_names($field_names);

        return $this;
    }

    /**
     * Set field names
     * Sets the field names to the array given
     * @param array $field_names
     */
    public function set_field_names($field_names = array())
    {
        if (!is_array($field_names)) {
            throw new Exception('CSV Library: Field names must be in the form of an array.');
        }

        $this->field_names = $field_names;
    }

    /**
     * Get field names
     * Retrieves the field names array
     * @return array
     */
    public function get_field_names()
    {
        return $this->field_names;
    }

    /**
     * Add field names
     * Adds the given field name(s) to the end or at $start
     * @param mixed|array $field_names
     * @param int $start
     */
    public function add_field_names($field_names, $start = null)
    {
        if (!is_array($field_names)) {
            $field_names = array($field_names);
        }

        if ($start === null) {
            $this->field_names = array_merge($this->field_names, $field_names);
        } else {
            array_splice($this->field_names, (int) $start, 0, $field_names);
        }

    }

    /**
     * Replace field names
     * Replaces the field name(s) from $start until the number of given field names is depleted
     * @param mixed|array $field_names
     * @param int $start
     */
    public function replace_field_names($field_names, $start = 0)
    {
        if (!is_array($field_names)) {
            $field_names = array($field_names);
        }

        if (count($this->field_names) < (count($field_names) + (int) $start)) {
            throw new Exception('CSV Library: More replacement field names then actual field names.');
        }

        array_splice($this->field_names, (int) $start, count($field_names), $field_names);
    }

    /**
     * Remove field names
     * Removes the field(s) given in $field_names, may be both the name(s) or its key(s)
     * @param mixed|array $field_names
     */
    public function remove_field_names($field_names)
    {
        if (!is_array($field_names)) {
            $field_names = array($field_names);
        }

        foreach ($field_names as $fn) {
            if (!is_int($fn)) {
                $fn = array_search($fn, $this->field_names);
            }

            if (!array_key_exists($fn, $this->field_names)) {
                throw new Exception('CSV Library: Non existent field name given for removal.');
            }

            unset($this->field_names[$fn]);
            // Re-index after unset
            $this->field_names = array_merge($this->field_names);
        }
    }

    /**
     * Get contents
     * Returns the CSV values as a 2 dimensional array
     * @param $use_field_names
     * @return array(array())
     */
    public function get_contents($use_field_names = false)
    {
        if ($use_field_names === true) {
            $output = array();
            foreach ($this->contents as $row) {
                $temp = array();
                foreach ($row as $i => $val) {
                    $temp[@$this->field_names[$i]] = $val;
                }

                $output[] = $temp;
            }
            return $output;
        } else {
            return $this->contents;
        }
    }

    /**
     * Find row
     * Finds the first row that meet the $conditions where keys are the column-nrs and their values must match
     * the values of the cells in the row at those columns. Returns the line nr or FALSE when no more can be found.
     * It starts searching from the begining or from the line given in $start.
     * @param array $conditions
     * @param int $start
     * @return int
     */
    public function find_row($conditions, $start = null)
    {
        $start_found = false;
        foreach ($this->contents as $line_nr => $line) {
            if (!$start_found && $start === $line_nr) {
                $start_found = true;
            } elseif (!$start_found && $start !== null) {
                continue;
            }

            $found = false;
            foreach ($condition as $key => $val) {
                if (!is_int($key)) {
                    $key = array_search($key, $this->field_names);
                }

                if ($line[$key] == $val) {
                    $found = true;
                } else {
                    $found = false;
                }

            }
            if ($found) {
                return $line_nr;
            }
        }

        return false;
    }

    /**
     * Find rows
     * Utelizes find_row() to find all rows matching the $conditions
     * @param <type> $condition
     * @return <type>
     */
    public function find_all_rows($conditions)
    {
        $rows = array();
        $start = 0;
        while ($next = $this->find_row($conditions, $start)) {
            $rows[] = $next;
            $start = $next + 1;
        }
        return $rows;
    }

    /**
     * Add row
     * Adds a row at the end or at line $at_line when specified
     * @param array $row
     * @param int $at_line
     * @return Csv
     */
    public function add_row($row = array(), $at_line = null)
    {
        if (!is_array($row)) {
            throw new Exception('CSV Library: Row must be in the form of an array.');
        }

        if ($at_line === null) {
            array_push($this->contents, $row);
        } elseif ($at_line <= count($this->contents)) {
            array_splice($this->contents, $at_line, 0, array($row));
        } else {
            throw new Exception('CSV Library: Row line for insertion cannot be larger then the number of rows.');
        }

        return $this;
    }

    /**
     * Remove row
     * Either replaces the row at the line specified by $conditions (when int) or $conditions is an array
     * of conditions with row nrs as its keys and expected values - when the conditions are met the row is replaced.
     * It will delete (instead of replace) when $new_row is set to FALSE.
     * @param array|bool $new_row
     * @param int|array $conditions
     * @return array the deleted row(s)
     */
    public function replace_rows($new_row, $conditions)
    {
        if (!is_array($new_row) && $new_row !== false) {
            throw new Exception('CSV Library: Replacement row must be in the form of an array, or FALSE for deletion.');
        }

        if (is_int($conditions)) {
            if (!array_key_exists($conditions, $this->contents)) {
                throw new Exception('CSV Library: Row for replacement/removal could not be found.');
            }

            $return = $this->contents[$conditions];
            if ($new_row !== false) {
                $this->contents[$conditions] = $new_row;
            } else {
                unset($this->contents[$conditions]);
                // Re-index after unset
                $this->contents = array_merge($this->contents);
            }

            return $return;
        }

        $rows = $this->find_all_rows($conditions);
        $return = array();
        foreach ($rows as $r) {
            $return[] = $this->contents[$r];
            if ($new_row !== false) {
                $this->contents[$r] = $new_row;
            } else {
                unset($this->contents[$r]);
            }

        }
        // Reindex line numbers when one was removed
        if ($new_row === false) {
            $this->contents = array_merge($this->contents);
        }

        return $return;
    }

    /**
     * Remove row
     * Utelizes replace_rows to find and delete rows.
     * @param int|array $conditions
     * @return array the deleted row(s)
     */
    public function remove_rows($conditions)
    {
        return $this->replace_rows(false, $conditions);
    }

    /**
     * Add column
     * Adds a column at $position, will create blank fields if there's not enough cells before $position.
     * The fields will be filled with $value.
     * If value is passed as an array the values will be used untill they're depleted, cells will be
     * empty after that point.
     * @param int $position
     * @param mixed|array $value
     */
    public function add_column($position, $value = '')
    {
        if (!is_array($value)) {
            $value = array($value);
        }

        $i = 0;
        $nr_values = count($value);
        foreach ($this->contents as $line_nr => $line) {
            $fields = count($this->contents[$line_nr]);
            if ($fields < ((int) $position + 1)) {
                $new_cells = array();
                while ($fields < (int) $position) {
                    $new_cells[] = '';
                    $fields++;
                }
                $new_cells[] = @$value[$i];
                $this->add_cells($new_cells, $line_nr);
            } else {
                array_splice($this->contents[$line_nr], (int) $position, 0, @$value[$i]);
            }

            if ($nr_values > 1) {
                $i++;
            }

        }
    }

    /**
     * Remove column
     * Removes the column at $position
     * @param int $position
     * @return array the removed values with their line_nr as keys
     */
    public function remove_column($position)
    {
        $return = array();
        foreach ($this->contents as $line_nr => $line) {
            if (array_key_exists((int) $position, $this->contents[$line_nr])) {
                $return[$line_nr] = $this->contents[$line_nr][(int) $position];
                unset($this->contents[$line_nr][(int) $position]);
                // reindex after removal
                //$this->contents[$line_nr][(int) $position] = array_merge( $this->contents[$line_nr][(int) $position] );
            }
        }

        return $return;
    }

    /**
     * Replace column
     * All values in the column at $position will be replaced by $value. If there's not enough cells, blank
     * cells will be added up to the $position.
     * When $replace is passed as an array the replacement is done untill there's no more rows or until the
     * array is depleted.
     * @param int $position
     * @param mixed|array $replace
     * @return array the replaced values with their line_nr as keys
     */
    public function replace_column($position, $replace = '')
    {
        if (!is_array($replace)) {
            $replace = array($replace);
        }

        $i = 0;
        $nr_values = count($replace);
        $return = array();
        foreach ($this->contents as $line_nr => $line) {
            $fields = count($this->contents[$line_nr]);
            if ($fields > ((int) $position + 1)) {
                $this->add_cells($value[$i], $line_nr, $position);
            } else {
                $return[$line_nr] = $this->contents[$line_nr][(int) $position];
                $this->contents[$line_nr][(int) $position] = $value[$i];
            }

            if ($nr_values > 1) {
                $i++;
                if ($i >= $nr_values) {
                    break;
                }

            }
        }
        return $return;
    }

    /**
     * Add cells
     * Adds cells at the position of $at_position in the end of $this->contents or at the end
     * of the line $at_line when specified.
     * @param mixed|array $value
     * @param int $at_line
     * @param int $at_position
     * @return Csv
     */
    public function add_cells($value, $at_line = null, $at_position = null)
    {
        if (!is_array($value)) {
            $value = array($value);
        }

        if ($at_line === null) {
            if (empty($this->contents)) {
                $this->contents[] = array();
            }

            $line = &$this->contents[count($this->contents) - 1];
            if ($at_position === null) {
                $line = array_merge($line, $value);
            } else {
                $nr_cells = count($line);
                if ($nr_cells < ((int) $at_position + 1)) {
                    $new_cells = array();
                    while ($nr_cells < (int) $at_position) {
                        $new_cells[] = '';
                        $nr_cells++;
                    }
                    $value = array_merge($new_cells, $value);
                    $line = array_merge($line, $value);
                } else {
                    $line = array_splice($line, $at_position, 0, $value);
                }

            }
        } else {
            if (!array_key_exists($at_line, $this->contents)) {
                throw new Exception('CSV Library: Line for inserting cells could not be found.', 2048);
            }

            $line = &$this->contents[$at_line];
            if ($at_position === null) {
                $line = array_merge((array) $line, $value);
            } else {
                $nr_cells = count($line);
                if ($nr_cells < ((int) $at_position + 1)) {
                    $new_cells = array();
                    while ($nr_cells < (int) $at_position) {
                        $new_cells[] = '';
                        $nr_cells++;
                    }
                    $value = array_merge($new_cells, $value);
                    $line = array_merge($line, $value);
                } else {
                    $line = array_splice($line, $at_position, 0, $value);
                }

            }
        }

        return $this;
    }

    /**
     * Replace Cells
     * Either replaces a single cell when $search is in the form of array($line, $row)
     * or finds cells with the value in $search and replaces them with $replace
     * when $at_line is set the latter only happens at that specific line
     * @param array|mixed $search
     * @param mixed $replace
     * @param int $at_line
     * @return mixed|array returns the value when $search is an array, returns an array of row nrs when $at_line is
     *                        set or an array of coordinates in the form of array($line, $row)
     */
    public function replace_cells($search, $replace, $at_line = null)
    {
        if (is_array($search) && count($search) == 2) {
            if (!array_key_exists($search[0], $this->contents) &&
                !array_key_exists($search[1], $this->contents[$search[0]])) {
                throw new Exception('CSV Library: Cell for replacement/removal could not be found.');
            }

            $return = $this->contents[$search[0]][$search[1]];
            if ($replace === false) {
                unset($this->contents[$search[0]][$search[1]]);
                // Re-index after unset
                $this->contents[$search[0]][$search[1]] = array_merge($this->contents[$search[0]][$search[1]]);
            } else {
                $this->contents[$search[0]][$search[1]] = $replace;
            }

            return $return;
        }

        if (is_int($at_line)) {
            if (!array_key_exists($at_line, $this->contents)) {
                throw new Exception('CSV Library: Line for replacing/removing cells could not be found.');
            }

            $line = &$this->contents[$at_line];

            $return = array();
            while (($k = array_search($search, $line)) !== false) {
                $return[] = $k;
                if ($replace === false) {
                    unset($line[$k]);
                    // Re-index after unset
                    $line[$k] = array_merge($line[$k]);
                } else {
                    $line[$k] = $replace;
                }

            }

            return $return;
        }

        $return = array();
        foreach ($this->contents as $k => $v) {
            while (($k2 = array_search($search, $this->contents[$k])) !== false) {
                $return[] = array($k, $k2);
                if ($replace === false) {
                    unset($this->contents[$k][$k2]);
                    // Re-index after unset
                    $this->contents[$k][$k2] = array_merge($this->contents[$k][$k2]);
                } else {
                    $this->contents[$k][$k2] = $replace;
                }

            }
        }

        return $return;
    }

    /**
     * Remove cells
     * Removes cells containing $search, uses replace_cells()
     * @param mixed $search
     * @param int $at_line
     * @return array
     */
    public function remove_cells($search, $at_line = null)
    {
        return $this->replace_cells($search, false, $at_line);
    }
}

/* End of file Csv.php */
