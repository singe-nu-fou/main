<?php
    class recently_worked{
        public static function tbody(){
            return '<tr>
                        <td><input class="checkbox" type="checkbox" style="display:none;">Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                    </tr>';
        }
        
        public static function resultControl(){
            return '<div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Results
                                </span>
                                <select class="form-control">
                                
                                </select>
                                <span class="input-group-addon">
                                    Filter
                                </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>';
        }
    }